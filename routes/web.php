<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\LandingPage;
use App\Livewire\CatalogPage;
use App\Livewire\ProductDetailPage;
use App\Livewire\BrandHubPage;
use App\Livewire\CartPage;
use App\Livewire\CheckoutPage;
use App\Livewire\InvoicePage;
use App\Livewire\AboutPage;
use App\Livewire\ContactPage;
use App\Livewire\NotificationsPage;

Route::get('/', LandingPage::class)->name('home');
Route::get('/catalog', CatalogPage::class)->name('catalog');
Route::get('/product/{slug}', ProductDetailPage::class)->name('product.detail');
Route::get('/brands', BrandHubPage::class)->name('brands');
Route::get('/cart', CartPage::class)->name('cart');

// Authentication gated checkout routes
Route::middleware(['auth'])->group(function () {
    Route::get('/checkout', CheckoutPage::class)->name('checkout');
    Route::get('/invoices', InvoicePage::class)->name('invoices');
    Route::get('/notifications', NotificationsPage::class)->name('notifications');
});

// Public info pages
Route::get('/about-us', AboutPage::class)->name('about');
Route::get('/contact-us', ContactPage::class)->name('contact');
