<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartPage extends Component
{
    public $cart = [];
    public $wishlist = [];
    public $activeTab = 'cart'; // cart, wishlist

    protected $listeners = [
        'cartUpdated' => 'loadCart',
        'wishlistUpdated' => 'loadWishlist',
    ];

    public function mount()
    {
        $this->activeTab = request()->query('tab', 'cart');
        $this->loadCart();
        $this->loadWishlist();
    }

    public function loadCart()
    {
        $this->cart = session()->get('cart', []);
    }

    public function loadWishlist()
    {
        $wishlistIds = session()->get('wishlist', []);
        $this->wishlist = Product::whereIn('id', $wishlistIds)->get();
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function incrementQuantity($productId)
    {
        if (isset($this->cart[$productId])) {
            $product = Product::find($productId);
            if ($product && $this->cart[$productId]['quantity'] < $product->stock) {
                $this->cart[$productId]['quantity']++;
                session()->put('cart', $this->cart);
                $this->dispatch('cartUpdated');
            } else {
                session()->flash('cart_error_' . $productId, 'Stok tidak mencukupi untuk menambah unit.');
            }
        }
    }

    public function decrementQuantity($productId)
    {
        if (isset($this->cart[$productId])) {
            if ($this->cart[$productId]['quantity'] > 1) {
                $this->cart[$productId]['quantity']--;
                session()->put('cart', $this->cart);
                $this->dispatch('cartUpdated');
            } else {
                $this->removeFromCart($productId);
            }
        }
    }

    public function removeFromCart($productId)
    {
        if (isset($this->cart[$productId])) {
            unset($this->cart[$productId]);
            session()->put('cart', $this->cart);
            $this->dispatch('cartUpdated');
        }
    }

    public function moveToWishlist($productId)
    {
        if (!Auth::check()) {
            $this->dispatch('triggerAuthGate');
            return;
        }

        // Add to wishlist
        $wishlist = session()->get('wishlist', []);
        if (!in_array($productId, $wishlist)) {
            $wishlist[] = $productId;
            session()->put('wishlist', $wishlist);
        }

        // Remove from cart
        $this->removeFromCart($productId);
        $this->loadWishlist();
        $this->dispatch('wishlistUpdated');
    }

    public function moveFromWishlistToCart($productId)
    {
        if (!Auth::check()) {
            $this->dispatch('triggerAuthGate');
            return;
        }

        $product = Product::find($productId);
        if (!$product || $product->stock <= 0) return;

        // Add to cart
        $this->cart = session()->get('cart', []);
        if (isset($this->cart[$productId])) {
            $this->cart[$productId]['quantity']++;
        } else {
            $this->cart[$productId] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'image_path' => $product->image_path,
            ];
        }
        session()->put('cart', $this->cart);

        // Remove from wishlist
        $wishlist = session()->get('wishlist', []);
        $wishlist = array_diff($wishlist, [$productId]);
        session()->put('wishlist', $wishlist);

        $this->loadCart();
        $this->loadWishlist();
        $this->dispatch('cartUpdated');
        $this->dispatch('wishlistUpdated');
        session()->flash('success_cart_move', 'Item dipindahkan ke tas belanja!');
    }

    public function removeFromWishlist($productId)
    {
        $wishlist = session()->get('wishlist', []);
        $wishlist = array_diff($wishlist, [$productId]);
        session()->put('wishlist', $wishlist);
        
        $this->loadWishlist();
        $this->dispatch('wishlistUpdated');
    }

    public function proceedToCheckout()
    {
        if (!Auth::check()) {
            $this->dispatch('triggerAuthGate');
            return;
        }
        return redirect()->route('checkout');
    }

    public function render()
    {
        $subtotal = 0;
        foreach ($this->cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        return view('livewire.cart-page', [
            'subtotal' => $subtotal,
        ]);
    }
}
