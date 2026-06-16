<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;
use App\Models\Notification;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class InvoicePage extends Component
{
    public $orderNumber;
    public $selectedOrder;
    public $timeLeftString = '';

    public function mount()
    {
        $this->orderNumber = request()->query('order', '');
        $this->loadOrder();
    }

    public function loadOrder()
    {
        if ($this->orderNumber) {
            $this->selectedOrder = Order::with('items.product')
                ->where('user_id', Auth::id())
                ->where('order_number', $this->orderNumber)
                ->first();
            $this->calculateTimeLeft();
        } else {
            $this->selectedOrder = null;
        }
    }

    public function selectInvoice($number)
    {
        $this->orderNumber = $number;
        $this->loadOrder();
    }

    public function calculateTimeLeft()
    {
        if ($this->selectedOrder && $this->selectedOrder->payment_expires_at) {
            $diff = now()->diffInSeconds($this->selectedOrder->payment_expires_at, false);
            if ($diff > 0) {
                if ($this->selectedOrder->payment_method === 'QRIS') {
                    // 10-minute formatting: MM:SS
                    $minutes = floor($diff / 60);
                    $seconds = $diff % 60;
                    $this->timeLeftString = sprintf('%02d:%02d', $minutes, $seconds);
                } else {
                    // 24-hour formatting: HH:MM:SS
                    $hours = floor($diff / 3600);
                    $minutes = floor(($diff % 3600) / 60);
                    $seconds = $diff % 60;
                    $this->timeLeftString = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
                }
            } else {
                $this->timeLeftString = 'EXPIRED';
                if ($this->selectedOrder->status === 'Created' && $this->selectedOrder->payment_status === 'Pending') {
                    // Automatically cancel if expired
                    $this->selectedOrder->update([
                        'status' => 'Cancelled',
                        'payment_status' => 'Cancelled',
                        'cancelled_at' => now()
                    ]);
                }
            }
        }
    }

    // Testing Simulator: instant simulated payment capture
    public function simulatePayment()
    {
        if (!$this->selectedOrder || $this->selectedOrder->status !== 'Created') return;

        $this->selectedOrder->update([
            'status' => 'Paid',
            'payment_status' => 'Paid'
        ]);

        Notification::create([
            'user_id' => Auth::id(),
            'type' => 'logistics',
            'title' => 'Pembayaran Terverifikasi!',
            'message' => "Pembayaran untuk pesanan {$this->selectedOrder->order_number} telah kami terima. Tim kami sedang menyiapkan boks game Anda.",
            'target_url' => '/invoices?order=' . $this->selectedOrder->order_number,
        ]);
        $this->dispatch('notificationsUpdated');

        $this->loadOrder();
        session()->flash('simulation_msg', 'Pembayaran berhasil disimulasikan!');
    }

    // Order Management: Customer manually aborts unfulfilled orders
    public function cancelOrder()
    {
        if (!$this->selectedOrder || $this->selectedOrder->status !== 'Created') return;

        // Restore stock
        foreach ($this->selectedOrder->items as $item) {
            $product = Product::find($item->product_id);
            if ($product) {
                $product->increment('stock', $item->quantity);
                $product->decrement('sold_count', $item->quantity);
            }
        }

        $this->selectedOrder->update([
            'status' => 'Cancelled',
            'payment_status' => 'Cancelled',
            'cancelled_at' => now(),
        ]);

        Notification::create([
            'user_id' => Auth::id(),
            'type' => 'logistics',
            'title' => 'Pesanan Dibatalkan',
            'message' => "Pesanan {$this->selectedOrder->order_number} berhasil dibatalkan secara manual.",
            'target_url' => '/invoices?order=' . $this->selectedOrder->order_number,
        ]);
        $this->dispatch('notificationsUpdated');

        $this->loadOrder();
        session()->flash('simulation_msg', 'Pesanan Anda berhasil dibatalkan.');
    }

    public function render()
    {
        $this->calculateTimeLeft();
        
        $allOrders = Order::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('livewire.invoice-page', [
            'orders' => $allOrders,
        ]);
    }
}
