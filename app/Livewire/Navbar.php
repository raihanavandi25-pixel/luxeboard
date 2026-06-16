<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;
use App\Models\Notification;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class Navbar extends Component
{
    public $search = '';
    public $categoriesList = [];
    
    protected $listeners = [
        'cartUpdated' => '$refresh',
        'wishlistUpdated' => '$refresh',
        'notificationsUpdated' => '$refresh',
        'userAuthenticated' => '$refresh',
    ];

    public function mount()
    {
        $this->categoriesList = Category::all();
        $this->search = request()->query('search', '');
    }

    public function updatedSearch()
    {
        // If we are on the catalog page, dispatch real-time search.
        // Otherwise, redirect to catalog page with search parameter.
        if (request()->routeIs('catalog')) {
            $this->dispatch('searchTriggered', $this->search);
        } else {
            return redirect()->to('/catalog?search=' . urlencode($this->search));
        }
    }

    public function submitSearch()
    {
        return redirect()->to('/catalog?search=' . urlencode($this->search));
    }

    public function markAsRead($notificationId)
    {
        $notification = Notification::find($notificationId);
        if ($notification && $notification->user_id === Auth::id()) {
            $notification->update(['read_at' => now()]);
            $this->dispatch('notificationsUpdated');
            
            if ($notification->target_url) {
                return redirect()->to($notification->target_url);
            }
        }
    }

    public function triggerAuth()
    {
        $this->dispatch('triggerAuthGate');
    }

    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->to('/');
    }

    public function render()
    {
        $cart = session()->get('cart', []);
        $wishlist = session()->get('wishlist', []);
        
        $cartCount = array_sum(array_column($cart, 'quantity'));
        $wishlistCount = count($wishlist);

        // Fetch recent cart items for the floating preview (max 2)
        $cartPreview = array_slice($cart, -2, 2, true);
        
        // Fetch recent wishlist items for preview (max 2)
        $wishlistPreview = [];
        if (!empty($wishlist)) {
            $wishlistPreview = Product::whereIn('id', array_slice($wishlist, -2))->get();
        }

        // Fetch notifications
        $notifications = [];
        $unreadNotificationsCount = 0;
        if (Auth::check()) {
            $notifications = Notification::where('user_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();
            
            $unreadNotificationsCount = Notification::where('user_id', Auth::id())
                ->whereNull('read_at')
                ->count();
        }

        return view('livewire.navbar', [
            'cartCount' => $cartCount,
            'wishlistCount' => $wishlistCount,
            'cartPreview' => $cartPreview,
            'wishlistPreview' => $wishlistPreview,
            'notifications' => $notifications,
            'unreadCount' => $unreadNotificationsCount,
        ]);
    }
}
