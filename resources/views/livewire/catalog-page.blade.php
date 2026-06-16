<div class="max-w-7xl mx-auto px-6 py-12">
    <div class="flex flex-col md:flex-row gap-10">
        
        <!-- Sidebar Filters -->
        <div class="w-full md:w-1/4 space-y-8">
            <div>
                <h3 class="text-xs uppercase tracking-[0.2em] text-gold-burnished font-semibold mb-4">Butik Kategori</h3>
                <div class="flex flex-col space-y-2">
                    <button wire:click="selectCategory('')" 
                            class="text-left text-xs uppercase tracking-wider py-2 px-3 rounded-lg transition-all {{ $selectedCategory === '' ? 'bg-moss-slate text-gold-burnished font-bold border-l-2 border-gold-burnished' : 'text-gray-400 hover:text-white hover:bg-moss-slate/20' }}">
                        Semua Kategori
                    </button>
                    @foreach($categories as $cat)
                        <button wire:click="selectCategory('{{ $cat->slug }}')" 
                                class="text-left text-xs uppercase tracking-wider py-2 px-3 rounded-lg transition-all {{ $selectedCategory === $cat->slug ? 'bg-moss-slate text-gold-burnished font-bold border-l-2 border-gold-burnished' : 'text-gray-400 hover:text-white hover:bg-moss-slate/20' }}">
                            {{ $cat->name }}
                        </button>
                    @endforeach
                </div>
            </div>

            <div>
                <h3 class="text-xs uppercase tracking-[0.2em] text-gold-burnished font-semibold mb-4">Penerbit Game (Studios)</h3>
                <div class="flex flex-col space-y-2">
                    <button wire:click="selectBrand('')" 
                            class="text-left text-xs uppercase tracking-wider py-2 px-3 rounded-lg transition-all {{ $selectedBrand === '' ? 'bg-moss-slate text-gold-burnished font-bold border-l-2 border-gold-burnished' : 'text-gray-400 hover:text-white hover:bg-moss-slate/20' }}">
                        Semua Penerbit
                    </button>
                    @foreach($brands as $brand)
                        <button wire:click="selectBrand('{{ $brand->slug }}')" 
                                class="text-left text-xs uppercase tracking-wider py-2 px-3 rounded-lg transition-all {{ $selectedBrand === $brand->slug ? 'bg-moss-slate text-gold-burnished font-bold border-l-2 border-gold-burnished' : 'text-gray-400 hover:text-white hover:bg-moss-slate/20' }}">
                            {{ $brand->name }}
                        </button>
                    @endforeach
                </div>
            </div>

            @if($selectedCategory || $selectedBrand || $search)
                <button wire:click="resetFilters" class="w-full bg-moss-slate/50 hover:bg-moss-slate border border-moss-emerald/50 text-gray-300 hover:text-white text-xs uppercase tracking-wider py-3 rounded-lg transition-all">
                    Reset Semua Filter
                </button>
            @endif
        </div>

        <!-- Product Grid -->
        <div class="w-full md:w-3/4 space-y-6">
            <!-- Search Results header -->
            @if($search)
                <div class="bg-moss-slate/30 border border-moss-slate/50 rounded-xl p-4 flex justify-between items-center">
                    <span class="text-xs text-gray-300">
                        Menampilkan hasil pencarian untuk "<span class="text-gold-burnished font-semibold">{{ $search }}</span>" ({{ count($products) }} item ditemukan)
                    </span>
                    <button wire:click="resetFilters" class="text-[10px] uppercase font-bold text-gold-burnished hover:underline">Hapus</button>
                </div>
            @endif

            @if(count($products) == 0)
                <div class="bg-moss-slate/20 border border-moss-slate/40 rounded-2xl p-16 text-center text-gray-400 font-light space-y-4">
                    <i class="fa-solid fa-chess-board text-5xl text-moss-emerald/20"></i>
                    <p class="text-sm">Tidak ada board game yang cocok dengan pilihan filter Anda.</p>
                    <button wire:click="resetFilters" class="text-xs font-semibold text-gold-burnished hover:underline uppercase">Kembali ke Katalog Lengkap</button>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($products as $prod)
                        <div class="bg-moss-slate/40 border border-moss-slate/50 hover:border-moss-emerald rounded-2xl p-5 flex flex-col justify-between group hover:-translate-y-1 transition-all duration-300 relative">
                            
                            <!-- Heart (Wishlist) Button -->
                            <button wire:click="toggleWishlist({{ $prod->id }})" class="absolute top-8 right-8 z-10 text-gray-400 hover:text-gold-burnished transition-colors">
                                @if(in_array($prod->id, $wishlist))
                                    <i class="fa-solid fa-heart text-gold-burnished text-sm"></i>
                                @else
                                    <i class="fa-regular fa-heart text-sm"></i>
                                @endif
                            </button>

                            <!-- Toast / Success banner overlay -->
                            @if (session()->has('cart_success_' . $prod->id))
                                <div class="absolute inset-x-5 top-5 z-20 bg-gold-burnished text-moss-deep text-[10px] font-bold rounded-lg py-2 text-center shadow-lg transition-opacity duration-500">
                                    {{ session('cart_success_' . $prod->id) }}
                                </div>
                            @endif

                            <div class="space-y-4">
                                <!-- Image with locked aspect-ratio -->
                                <div class="aspect-square w-full rounded-xl bg-moss-deep border border-moss-emerald/25 flex flex-col items-center justify-center text-center relative overflow-hidden">
                                    @if($prod->image_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($prod->image_path))
                                        <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($prod->image_path) }}" class="h-full w-full object-cover">
                                    @else
                                        <div class="absolute inset-0 bg-[#2C3A2E] flex flex-col items-center justify-center p-6 text-center">
                                            <i class="fa-solid fa-chess-knight text-3xl text-moss-emerald/20 mb-2"></i>
                                            <span class="text-xs font-serif text-white font-medium px-2 leading-snug">{{ $prod->name }}</span>
                                        </div>
                                    @endif

                                    <!-- Badges -->
                                    <div class="absolute bottom-2 left-2 flex gap-1.5">
                                        <span class="bg-moss-deep/90 text-gold-burnished text-[9px] px-2 py-0.5 rounded border border-gold-burnished/20 font-semibold flex items-center">
                                            <i class="fa-solid fa-star text-[8px] mr-1"></i>{{ number_format($prod->rating, 1) }}
                                        </span>
                                        <span class="bg-moss-deep/90 text-gray-400 text-[8px] px-2 py-0.5 rounded border border-moss-emerald/30">
                                            Terjual {{ $prod->sold_count }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Meta Info -->
                                <div class="space-y-1.5">
                                    <div class="text-[9px] text-gold-burnished uppercase tracking-widest font-semibold flex justify-between">
                                        <span>{{ $prod->brand->name }}</span>
                                        @if($prod->stock <= 3 && $prod->stock > 0)
                                            <span class="text-red-400">Tinggal {{ $prod->stock }} Unit!</span>
                                        @elseif($prod->stock == 0)
                                            <span class="text-red-500">Habis</span>
                                        @endif
                                    </div>
                                    <h3 class="text-base font-serif text-white group-hover:text-gold-burnished transition-colors duration-300 truncate">
                                        <a href="/product/{{ $prod->slug }}">{{ $prod->name }}</a>
                                    </h3>
                                    <p class="text-xs text-gray-400 leading-relaxed font-light line-clamp-2">
                                        {{ $prod->description }}
                                    </p>
                                </div>
                            </div>

                            <!-- Actions & Pricing -->
                            <div class="pt-4 border-t border-moss-slate/50 mt-5 space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-xs text-gray-400">Harga Sanctuary</span>
                                    <span class="text-sm text-gold-burnished font-bold">Rp {{ number_format($prod->price, 0, ',', '.') }}</span>
                                </div>
                                <div class="grid grid-cols-2 gap-2 pt-1">
                                    <button wire:click="addToCart({{ $prod->id }})" {{ $prod->stock <= 0 ? 'disabled' : '' }}
                                            class="border border-moss-emerald hover:border-gold-burnished text-gray-300 hover:text-white disabled:opacity-40 disabled:cursor-not-allowed text-[10px] font-bold uppercase tracking-wider py-2.5 rounded-lg transition-all">
                                        + Tas
                                    </button>
                                    <button wire:click="buyNow({{ $prod->id }})" {{ $prod->stock <= 0 ? 'disabled' : '' }}
                                            class="bg-gold-burnished hover:bg-gold-dark text-moss-deep disabled:opacity-40 disabled:cursor-not-allowed text-[10px] font-bold uppercase tracking-wider py-2.5 rounded-lg transition-all shadow-md">
                                        Beli Sekarang
                                    </button>
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>
</div>
