<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CheckoutPage extends Component
{
    public $cart = [];
    public $recipient_name = '';
    public $recipient_phone = '';
    public $shipping_address = '';
    public $shipping_tier = 'Regular';
    public $payment_method = 'QRIS';

    public $shipping_fees = [
        'Regular' => 20000.00,
        'Same Day' => 50000.00,
        'Instant Next Day' => 100000.00,
        'Instant Priority Next Day' => 200000.00,
    ];

    public function mount()
    {
        $this->cart = session()->get('cart', []);
        
        if (count($this->cart) == 0) {
            return redirect()->route('cart');
        }

        if (Auth::check()) {
            $this->recipient_name = Auth::user()->name;
        }
    }

    public function placeOrder()
    {
        $this->validate([
            'recipient_name' => 'required|string|max:255',
            'recipient_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string|max:1000',
            'shipping_tier' => 'required|in:Regular,Same Day,Instant Next Day,Instant Priority Next Day',
            'payment_method' => 'required|in:QRIS,Bank Transfer,Debit Card,E-Wallet,COD',
        ]);

        // Verify stock levels before checkout
        foreach ($this->cart as $productId => $item) {
            $product = Product::find($productId);
            if (!$product || $product->stock < $item['quantity']) {
                $this->addError('cart', "Stok untuk game '{$item['name']}' tidak mencukupi atau telah berubah.");
                return;
            }
        }

        // Calculate Subtotal & Total
        $subtotal = 0;
        foreach ($this->cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        $shippingFee = $this->shipping_fees[$this->shipping_tier];
        $totalAmount = $subtotal + $shippingFee;

        // Calculate Expiry Date
        $expiresAt = null;
        if ($this->payment_method === 'QRIS') {
            $expiresAt = now()->addMinutes(10);
        } elseif (in_array($this->payment_method, ['Bank Transfer', 'Debit Card', 'E-Wallet'])) {
            $expiresAt = now()->addHours(24);
        }

        // Create Order
        $orderNumber = 'LXB-' . strtoupper(bin2hex(random_bytes(3))) . '-' . date('His');
        
        $order = Order::create([
            'user_id' => Auth::id(),
            'order_number' => $orderNumber,
            'status' => 'Created',
            'total_amount' => $totalAmount,
            'shipping_tier' => $this->shipping_tier,
            'shipping_fee' => $shippingFee,
            'payment_method' => $this->payment_method,
            'payment_status' => 'Pending',
            'shipping_address' => $this->shipping_address,
            'recipient_name' => $this->recipient_name,
            'recipient_phone' => $this->recipient_phone,
            'payment_expires_at' => $expiresAt,
        ]);

        // Create Items & Deduct Stock
        foreach ($this->cart as $productId => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $productId,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);

            $product = Product::find($productId);
            $product->decrement('stock', $item['quantity']);
            $product->increment('sold_count', $item['quantity']);
        }

        // Clear Session Cart
        session()->forget('cart');
        $this->dispatch('cartUpdated');

        // Create Logistics Notification
        \App\Models\Notification::create([
            'user_id' => Auth::id(),
            'type' => 'logistics',
            'title' => 'Tagihan Pesanan Terbit',
            'message' => "Pesanan {$orderNumber} berhasil dibuat. Silakan selesaikan pembayaran Anda.",
            'target_url' => '/invoices?order=' . $orderNumber,
        ]);
        $this->dispatch('notificationsUpdated');

        // Redirect to Invoice detailing page
        return redirect()->to('/invoices?order=' . $orderNumber);
    }

    public function render()
    {
        $subtotal = 0;
        foreach ($this->cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        $shippingFee = $this->shipping_fees[$this->shipping_tier];
        $total = $subtotal + $shippingFee;

        return view('livewire.checkout-page', [
            'subtotal' => $subtotal,
            'shippingFee' => $shippingFee,
            'total' => $total,
        ]);
    }
}
