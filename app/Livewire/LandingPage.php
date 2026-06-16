<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Category;

class LandingPage extends Component
{
    public $carouselIndex = 0;
    public $carouselItems = [];

    public function mount()
    {
        // Gather 3 premium board games for the landing page showcase loop
        $this->carouselItems = Product::where('is_featured', true)->take(3)->get()->toArray();
    }

    public function nextSlide()
    {
        $this->carouselIndex = ($this->carouselIndex + 1) % count($this->carouselItems);
    }

    public function prevSlide()
    {
        $this->carouselIndex = ($this->carouselIndex - 1 + count($this->carouselItems)) % count($this->carouselItems);
    }

    public function setSlide($index)
    {
        $this->carouselIndex = $index;
    }

    public function render()
    {
        $featuredProducts = Product::where('is_featured', true)->orderBy('rating', 'desc')->take(4)->get();
        $newArrivals = Product::where('is_new', true)->orderBy('created_at', 'desc')->take(3)->get();
        $categoriesList = Category::take(3)->get();

        return view('livewire.landing-page', [
            'featuredProducts' => $featuredProducts,
            'newArrivals' => $newArrivals,
            'categoriesList' => $categoriesList,
        ]);
    }
}
