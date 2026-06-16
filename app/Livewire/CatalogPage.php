<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Support\Facades\Auth;

class CatalogPage extends Component
{
    public $search = '';
    public $selectedCategory = '';
    public $selectedBrand = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'selectedCategory' => ['except' => ''],
        'selectedBrand' => ['except' => ''],
    ];

    protected $listeners = [
        'searchTriggered' => 'updateSearch',
    ];

    public function mount()
    {
        $this->selectedCategory = request()->query('category', $this->selectedCategory);
        $this->selectedBrand = request()->query('brand', $this->selectedBrand);
        $this->search = request()->query('search', $this->search);
    }

    public function updateSearch($searchQuery)
    {
        $this->search = $searchQuery;
    }

    public function selectCategory($slug)
    {
        $this->selectedCategory = $slug;
    }

    public function selectBrand($slug)
    {
        $this->selectedBrand = $slug;
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->selectedCategory = '';
        $this->selectedBrand = '';
    }

    public function addToCart($productId)
    {
        // Auth gate requirement:
        if (!Auth::check()) {
            $this->dispatch('triggerAuthGate');
            return;
        }

        $product = Product::find($productId);
        if (!$product || $product->stock <= 0) return;

        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
        } else {
            $cart[$productId] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'image_path' => $product->image_path,
            ];
        }

        session()->put('cart', $cart);
        $this->dispatch('cartUpdated');
        
        // Confirmation toast overlay
        session()->flash('cart_success_' . $productId, 'Mahakarya ditambahkan ke tas belanja!');
    }

    public function buyNow($productId)
    {
        // Auth gate requirement:
        if (!Auth::check()) {
            $this->dispatch('triggerAuthGate');
            return;
        }

        $product = Product::find($productId);
        if (!$product || $product->stock <= 0) return;

        $cart = session()->get('cart', []);

        // Put in cart
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
        } else {
            $cart[$productId] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'image_path' => $product->image_path,
            ];
        }
        
        session()->put('cart', $cart);
        $this->dispatch('cartUpdated');

        // Overpasses standard shopping cart buffers, instantly moving user session data directly into checkout
        return redirect()->route('checkout');
    }

    public function toggleWishlist($productId)
    {
        // Auth gate requirement:
        if (!Auth::check()) {
            $this->dispatch('triggerAuthGate');
            return;
        }

        $wishlist = session()->get('wishlist', []);

        if (in_array($productId, $wishlist)) {
            $wishlist = array_diff($wishlist, [$productId]);
        } else {
            $wishlist[] = $productId;
        }

        session()->put('wishlist', $wishlist);
        $this->dispatch('wishlistUpdated');
    }

    public function render()
    {
        $query = Product::with(['category', 'brand']);

        if (!empty($this->search)) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        if (!empty($this->selectedCategory)) {
            $query->whereHas('category', function($q) {
                $q->where('slug', $this->selectedCategory);
            });
        }

        if (!empty($this->selectedBrand)) {
            $query->whereHas('brand', function($q) {
                $q->where('slug', $this->selectedBrand);
            });
        }

        $products = $query->get();
        $categories = Category::all();
        $brands = Brand::all();
        $wishlist = session()->get('wishlist', []);

        return view('livewire.catalog-page', [
            'products' => $products,
            'categories' => $categories,
            'brands' => $brands,
            'wishlist' => $wishlist,
        ]);
    }
}
