<div class="max-w-7xl mx-auto px-6 py-12">
    
    <!-- Success Alert -->
    @if(session()->has('detail_success'))
        <div class="bg-gold-burnished/20 border border-gold-burnished/60 text-gold-burnished p-4 rounded-xl mb-8 flex justify-between items-center text-sm font-semibold">
            <span><i class="fa-solid fa-circle-check mr-2"></i> {{ session('detail_success') }}</span>
            <a href="/cart" class="underline uppercase tracking-wider text-xs">Tas Belanja &rarr;</a>
        </div>
    @endif

    @if(session()->has('wishlist_msg'))
        <div class="bg-moss-slate border border-moss-emerald/60 text-gray-300 p-4 rounded-xl mb-8 text-sm">
            {{ session('wishlist_msg') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
        
        <!-- Left: Image Showcase Frame -->
        <div class="w-full">
            <div class="aspect-[4/5] w-full rounded-2xl bg-moss-slate/50 border border-moss-slate/75 flex flex-col items-center justify-center relative overflow-hidden shadow-xl">
                @if($product->image_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($product->image_path))
                    <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($product->image_path) }}" class="h-full w-full object-cover">
                @else
                    <div class="absolute inset-0 bg-[#2C3A2E] flex flex-col items-center justify-center p-8 text-center">
                        <i class="fa-solid fa-chess-queen text-7xl text-moss-emerald/20 mb-4 animate-pulse"></i>
                        <span class="text-3xl font-serif text-white font-bold leading-tight max-w-sm mb-2">{{ $product->name }}</span>
                        <span class="text-xs uppercase tracking-[0.25em] text-gold-burnished font-semibold">Luxury Tabletop Showcase</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Right: Curated Details -->
        <div class="space-y-8">
            <div class="space-y-3">
                <span class="text-xs uppercase tracking-[0.25em] text-gold-burnished font-semibold">{{ $product->brand->name }}</span>
                <h1 class="text-4xl md:text-5xl font-serif text-white font-bold leading-tight tracking-wide">{{ $product->name }}</h1>
                
                <!-- Ratings System -->
                <div class="flex items-center space-x-3 text-xs text-gray-400">
                    <div class="flex text-gold-burnished gap-0.5">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fa-{{ $i <= round($product->rating) ? 'solid' : 'regular' }} fa-star"></i>
                        @endfor
                    </div>
                    <span class="font-semibold text-white">{{ number_format($product->rating, 1) }}</span>
                    <span>&bull;</span>
                    <span>{{ $product->reviews_count }} Ulasan Butik</span>
                    <span>&bull;</span>
                    <span>Terjual {{ $product->sold_count }} Unit</span>
                </div>
            </div>

            <!-- Price & Stock Status -->
            <div class="bg-moss-slate/30 border border-moss-slate/50 rounded-2xl p-6 flex justify-between items-center">
                <div class="space-y-1">
                    <span class="text-xs text-gray-400 uppercase tracking-wider">Harga Mahar</span>
                    <p class="text-2xl font-serif text-gold-burnished font-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                </div>
                <div class="text-right space-y-1">
                    <span class="text-xs text-gray-400 uppercase tracking-wider">Ketersediaan</span>
                    @if($product->stock <= 3 && $product->stock > 0)
                        <p class="text-sm font-semibold text-red-400">Terbatas (Tinggal {{ $product->stock }}!)</p>
                    @elseif($product->stock == 0)
                        <p class="text-sm font-semibold text-red-500">Stok Habis</p>
                    @else
                        <p class="text-sm font-semibold text-green-400">Tersedia ({{ $product->stock }} unit)</p>
                    @endif
                </div>
            </div>

            <!-- Narrative Description -->
            <div class="space-y-2">
                <h3 class="text-xs uppercase tracking-widest text-gold-burnished font-semibold">Deskripsi Karya</h3>
                <p class="text-sm text-gray-300 leading-relaxed font-light">
                    {{ $product->description }}
                </p>
            </div>

            <!-- Cinematic Access Specs Gate -->
            <div class="space-y-4">
                <h3 class="text-xs uppercase tracking-widest text-gold-burnished font-semibold">Spesifikasi Premium</h3>
                
                @if(!$showSpecs)
                    <!-- Blurred Spec Sheet Lock Screen -->
                    <div class="relative bg-moss-slate/10 border border-moss-emerald/20 rounded-2xl p-6 overflow-hidden h-36 flex items-center justify-center">
                        <div class="absolute inset-0 bg-moss-deep/80 backdrop-blur-md z-10 flex flex-col items-center justify-center text-center p-4 space-y-3">
                            <span class="text-gold-burnished text-sm"><i class="fa-solid fa-lock mr-2"></i> Kunci Kredensial Butik</span>
                            <button wire:click="tryAccessSpecs" class="bg-gold-burnished hover:bg-gold-dark text-moss-deep text-[10px] font-bold uppercase tracking-wider px-5 py-2 rounded-lg transition-colors shadow">
                                Buka Spesifikasi Detail
                            </button>
                        </div>
                        <div class="w-full grid grid-cols-3 text-center filter blur-sm">
                            <div><p class="text-xs text-gray-500 uppercase">Pemain</p><p class="text-sm text-white">4 Players</p></div>
                            <div><p class="text-xs text-gray-500 uppercase">Durasi</p><p class="text-sm text-white">90 Mins</p></div>
                            <div><p class="text-xs text-gray-500 uppercase">Usia</p><p class="text-sm text-white">12+ Thn</p></div>
                        </div>
                    </div>
                @else
                    <!-- Authenticated spec details -->
                    <div class="bg-moss-slate/30 border border-moss-slate/50 rounded-2xl p-6 grid grid-cols-3 text-center divide-x divide-moss-emerald/20">
                        <div class="space-y-1">
                            <span class="text-[10px] uppercase text-gray-400 tracking-wider">Pemain</span>
                            <p class="text-sm text-white font-medium"><i class="fa-solid fa-users text-gold-burnished mr-1"></i> {{ $product->player_count }}</p>
                        </div>
                        <div class="space-y-1">
                            <span class="text-[10px] uppercase text-gray-400 tracking-wider">Durasi Sesi</span>
                            <p class="text-sm text-white font-medium"><i class="fa-regular fa-clock text-gold-burnished mr-1"></i> {{ $product->play_time }}</p>
                        </div>
                        <div class="space-y-1">
                            <span class="text-[10px] uppercase text-gray-400 tracking-wider">Batas Usia</span>
                            <p class="text-sm text-white font-medium"><i class="fa-solid fa-cake-candles text-gold-burnished mr-1"></i> {{ $product->min_age }}+ Tahun</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Transaction Blocks -->
            <div class="flex items-center space-x-4 pt-4 border-t border-moss-slate/50">
                <button wire:click="toggleWishlist" class="h-14 px-6 border border-moss-emerald hover:border-gold-burnished rounded-xl flex items-center justify-center text-gray-300 hover:text-gold-burnished transition-colors">
                    @if($inWishlist)
                        <i class="fa-solid fa-heart text-gold-burnished text-lg"></i>
                    @else
                        <i class="fa-regular fa-heart text-lg"></i>
                    @endif
                </button>
                <button wire:click="addToCart" {{ $product->stock <= 0 ? 'disabled' : '' }}
                        class="h-14 flex-1 border border-moss-emerald hover:border-gold-burnished hover:text-white disabled:opacity-40 disabled:cursor-not-allowed text-xs font-bold uppercase tracking-wider rounded-xl transition-all">
                    Masukkan Tas Belanja
                </button>
                <button wire:click="buyNow" {{ $product->stock <= 0 ? 'disabled' : '' }}
                        class="h-14 flex-1 bg-gold-burnished hover:bg-gold-dark text-moss-deep disabled:opacity-40 disabled:cursor-not-allowed text-xs font-bold uppercase tracking-wider rounded-xl transition-all shadow-lg hover:shadow-gold-burnished/20">
                    Beli Langsung
                </button>
            </div>

        </div>

    </div>
</div>
