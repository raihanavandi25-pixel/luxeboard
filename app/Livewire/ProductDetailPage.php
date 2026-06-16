<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ProductDetailPage extends Component
{
    public $slug;
    public $product;
    public $showSpecs = false;

    public function mount($slug)
    {
        $this->slug = $slug;
        $this->product = Product::where('slug', $slug)->firstOrFail();
        
        // If already logged in, we can automatically show specs
        if (Auth::check()) {
            $this->showSpecs = true;
        }
    }

    public function tryAccessSpecs()
    {
        // Auth gate requirement:
        if (!Auth::check()) {
            $this->dispatch('triggerAuthGate');
            return;
        }
        $this->showSpecs = true;
    }

    public function addToCart()
    {
        if (!Auth::check()) {
            $this->dispatch('triggerAuthGate');
            return;
        }

        $cart = session()->get('cart', []);
        $productId = $this->product->id;

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
        } else {
            $cart[$productId] = [
                'name' => $this->product->name,
                'price' => $this->product->price,
                'quantity' => 1,
                'image_path' => $this->product->image_path,
            ];
        }

        session()->put('cart', $cart);
        $this->dispatch('cartUpdated');
        session()->flash('detail_success', 'Mahakarya ditambahkan ke tas belanja!');
    }

    public function buyNow()
    {
        if (!Auth::check()) {
            $this->dispatch('triggerAuthGate');
            return;
        }

        $cart = session()->get('cart', []);
        $productId = $this->product->id;

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
        } else {
            $cart[$productId] = [
                'name' => $this->product->name,
                'price' => $this->product->price,
                'quantity' => 1,
                'image_path' => $this->product->image_path,
            ];
        }

        session()->put('cart', $cart);
        $this->dispatch('cartUpdated');

        return redirect()->route('checkout');
    }

    public function toggleWishlist()
    {
        if (!Auth::check()) {
            $this->dispatch('triggerAuthGate');
            return;
        }

        $wishlist = session()->get('wishlist', []);
        $productId = $this->product->id;

        if (in_array($productId, $wishlist)) {
            $wishlist = array_diff($wishlist, [$productId]);
            session()->flash('wishlist_msg', 'Dihapus dari wishlist.');
        } else {
            $wishlist[] = $productId;
            session()->flash('wishlist_msg', 'Ditambahkan ke wishlist!');
        }

        session()->put('wishlist', $wishlist);
        $this->dispatch('wishlistUpdated');
    }

    public function render()
    {
        $wishlist = session()->get('wishlist', []);
        $inWishlist = in_array($this->product->id, $wishlist);

        return view('livewire.product-detail-page', [
            'inWishlist' => $inWishlist,
        ]);
    }
}
