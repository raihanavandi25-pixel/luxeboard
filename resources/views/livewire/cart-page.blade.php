<div class="max-w-7xl mx-auto px-6 py-12">
    
    <!-- Tab Headers -->
    <div class="flex space-x-6 border-b border-moss-slate/50 pb-4 mb-10">
        <button wire:click="setTab('cart')" class="text-xl font-serif font-semibold tracking-wide transition-all pb-2 relative {{ $activeTab === 'cart' ? 'text-white' : 'text-gray-400 hover:text-gray-200' }}">
            Tas Belanja (Cart)
            @if($activeTab === 'cart')
                <span class="absolute bottom-0 left-0 w-full h-[2px] bg-gold-burnished"></span>
            @endif
        </button>
        <button wire:click="setTab('wishlist')" class="text-xl font-serif font-semibold tracking-wide transition-all pb-2 relative {{ $activeTab === 'wishlist' ? 'text-white' : 'text-gray-400 hover:text-gray-200' }}">
            Wishlist Repo
            @if($activeTab === 'wishlist')
                <span class="absolute bottom-0 left-0 w-full h-[2px] bg-gold-burnished"></span>
            @endif
        </button>
    </div>

    <!-- Move to Cart Success Alert -->
    @if(session()->has('success_cart_move'))
        <div class="bg-gold-burnished/20 border border-gold-burnished/50 text-gold-burnished p-4 rounded-xl mb-6 text-xs font-semibold">
            {{ session('success_cart_move') }}
        </div>
    @endif

    <!-- Cart Tab Content -->
    @if($activeTab === 'cart')
        @if(count($cart) == 0)
            <div class="bg-moss-slate/20 border border-moss-slate/40 rounded-2xl p-16 text-center text-gray-400 font-light space-y-4">
                <i class="fa-solid fa-cart-arrow-down text-5xl text-moss-emerald/20"></i>
                <p class="text-sm">Tas belanja Anda saat ini masih kosong.</p>
                <a href="/catalog" class="inline-block bg-gold-burnished hover:bg-gold-dark text-moss-deep text-xs font-bold uppercase tracking-wider px-6 py-3 rounded-lg transition-colors shadow">
                    Mulai Belanja
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                <!-- Cart Items Table -->
                <div class="lg:col-span-2 space-y-6">
                    @foreach($cart as $productId => $item)
                        <div class="bg-moss-slate/30 border border-moss-slate/50 rounded-2xl p-6 flex flex-col sm:flex-row items-center gap-6 justify-between hover:border-moss-emerald transition-all duration-300 relative">
                            <!-- Left: Image & Name -->
                            <div class="flex items-center gap-4 w-full sm:w-auto">
                                <div class="h-16 w-16 bg-moss-deep border border-moss-emerald/30 rounded-xl flex items-center justify-center text-[10px] text-center font-bold text-gray-400 overflow-hidden uppercase relative">
                                    @if(!empty($item['image_path']) && \Illuminate\Support\Facades\Storage::disk('public')->exists($item['image_path']))
                                        <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($item['image_path']) }}" class="h-full w-full object-cover">
                                    @else
                                        <div class="absolute inset-0 bg-[#2C3A2E] flex items-center justify-center text-[10px] text-white font-bold p-1 text-center leading-snug">
                                            {{ substr($item['name'], 0, 3) }}
                                        </div>
                                    @endif
                                </div>
                                <div class="space-y-1">
                                    <h3 class="text-base font-serif text-white font-medium truncate max-w-xs sm:max-w-md">{{ $item['name'] }}</h3>
                                    <p class="text-xs text-gold-burnished">Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                                </div>
                            </div>

                            <!-- Center: Quantity Adjustment Controls -->
                            <div class="flex items-center space-x-3 bg-moss-deep border border-moss-emerald/30 px-3 py-1.5 rounded-lg">
                                <button wire:click="decrementQuantity({{ $productId }})" class="text-gray-400 hover:text-gold-burnished transition-colors">
                                    <i class="fa-solid fa-minus text-[10px]"></i>
                                </button>
                                <span class="text-xs font-bold text-white px-2">{{ $item['quantity'] }}</span>
                                <button wire:click="incrementQuantity({{ $productId }})" class="text-gray-400 hover:text-gold-burnished transition-colors">
                                    <i class="fa-solid fa-plus text-[10px]"></i>
                                </button>
                            </div>

                            <!-- Right: Total Price & Actions -->
                            <div class="flex sm:flex-col items-center sm:items-end justify-between sm:justify-center w-full sm:w-auto gap-4 pt-4 sm:pt-0 border-t sm:border-0 border-moss-slate/50">
                                <div class="text-right">
                                    <span class="text-[10px] text-gray-500 block uppercase">Subtotal</span>
                                    <span class="text-sm font-semibold text-white">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</span>
                                </div>
                                <div class="flex gap-2">
                                    <button wire:click="moveToWishlist({{ $productId }})" class="text-gray-400 hover:text-gold-burnished text-xs" title="Pindahkan ke Wishlist">
                                        <i class="fa-regular fa-heart mr-1.5"></i>Wishlist
                                    </button>
                                    <span class="text-gray-600">|</span>
                                    <button wire:click="removeFromCart({{ $productId }})" class="text-red-400 hover:text-red-300 text-xs">
                                        Hapus
                                    </button>
                                </div>
                            </div>

                            <!-- Error Message Overlay inside card -->
                            @if(session()->has('cart_error_' . $productId))
                                <span class="absolute bottom-2 left-6 text-[10px] text-red-400">{{ session('cart_error_' . $productId) }}</span>
                            @endif
                        </div>
                    @endforeach
                </div>

                <!-- Order Summary Card -->
                <div class="bg-moss-slate/40 border border-moss-slate/50 rounded-2xl p-6 h-fit space-y-6">
                    <h3 class="text-xs uppercase tracking-widest text-gold-burnished font-semibold pb-2 border-b border-moss-emerald/30">Ringkasan Pesanan</h3>
                    
                    <div class="space-y-4">
                        <div class="flex justify-between text-xs text-gray-400">
                            <span>Subtotal Barang</span>
                            <span class="text-white">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-xs text-gray-400">
                            <span>Biaya Pengiriman</span>
                            <span class="text-gray-500 italic">Dihitung di checkout</span>
                        </div>
                        
                        <div class="border-t border-moss-emerald/20 pt-4 flex justify-between items-baseline">
                            <span class="text-xs uppercase tracking-wider text-gray-300">Estimasi Total</span>
                            <span class="text-lg font-serif text-gold-burnished font-bold">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <button wire:click="proceedToCheckout" class="w-full bg-gold-burnished hover:bg-gold-dark text-moss-deep font-bold text-xs uppercase tracking-wider py-4 rounded-xl shadow-lg hover:shadow-gold-burnished/20 transition-all">
                        Lanjutkan Ke Checkout
                    </button>
                    <div class="text-center">
                        <a href="/catalog" class="text-[10px] uppercase font-bold text-gray-400 hover:text-white transition-colors duration-300">Kembali Belanja</a>
                    </div>
                </div>
            </div>
        @endif
    @endif

    <!-- Wishlist Tab Content -->
    @if($activeTab === 'wishlist')
        @if(count($wishlist) == 0)
            <div class="bg-moss-slate/20 border border-moss-slate/40 rounded-2xl p-16 text-center text-gray-400 font-light space-y-4">
                <i class="fa-regular fa-heart text-5xl text-moss-emerald/20"></i>
                <p class="text-sm">Wishlist Anda saat ini masih kosong.</p>
                <a href="/catalog" class="inline-block bg-moss-slate/50 border border-moss-emerald/50 text-gray-300 hover:text-white text-xs font-bold uppercase tracking-wider px-6 py-3 rounded-lg transition-colors shadow">
                    Telusuri Butik
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach($wishlist as $wProd)
                    <div class="bg-moss-slate/30 border border-moss-slate/50 rounded-2xl p-5 flex items-center justify-between hover:border-moss-emerald transition-all duration-300">
                        <div class="flex items-center gap-4">
                            <div class="h-16 w-16 bg-moss-deep border border-moss-emerald/30 rounded-xl flex items-center justify-center text-[10px] text-center font-bold text-gray-400 overflow-hidden uppercase relative">
                                @if($wProd->image_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($wProd->image_path))
                                    <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($wProd->image_path) }}" class="h-full w-full object-cover">
                                @else
                                    <div class="absolute inset-0 bg-[#2C3A2E] flex items-center justify-center text-[10px] text-white font-bold p-1 text-center leading-snug">
                                        {{ substr($wProd->name, 0, 3) }}
                                    </div>
                                @endif
                            </div>
                            <div class="space-y-1">
                                <h3 class="text-sm font-serif text-white font-medium truncate max-w-[150px] sm:max-w-xs">{{ $wProd->name }}</h3>
                                <p class="text-xs text-gold-burnished">Rp {{ number_format($wProd->price, 0, ',', '.') }}</p>
                                <span class="text-[9px] uppercase tracking-widest text-gray-500">{{ $wProd->brand->name }}</span>
                            </div>
                        </div>

                        <div class="flex flex-col items-end gap-2">
                            <button wire:click="moveFromWishlistToCart({{ $wProd->id }})" class="bg-gold-burnished hover:bg-gold-dark text-moss-deep text-[10px] font-bold uppercase tracking-wider px-4 py-2 rounded-lg transition-colors">
                                + Ke Tas
                            </button>
                            <button wire:click="removeFromWishlist({{ $wProd->id }})" class="text-red-400 hover:text-red-300 text-[10px] uppercase font-bold">
                                Hapus
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    @endif

</div>
