<div class="space-y-24 pb-20">
    
    <!-- Hero Chronicle Section -->
    <div class="relative bg-moss-slate/40 border-b border-moss-slate/50 overflow-hidden py-32 flex items-center justify-center">
        <!-- Editorial Background vignette overlay -->
        <div class="absolute inset-0 bg-radial-vignette opacity-90 pointer-events-none"></div>
        <div class="max-w-4xl mx-auto px-6 text-center relative z-10 space-y-8">
            <span class="text-xs uppercase tracking-[0.35em] text-gold-burnished font-semibold">Luxury Tabletop Sanctuary</span>
            <h1 class="text-5xl md:text-7xl font-serif text-white leading-tight font-extrabold tracking-wide">
                Gerbang Menuju Dunia Strategi & Seni Meja
            </h1>
            <p class="text-base text-gray-300 max-w-2xl mx-auto font-light leading-relaxed">
                Kami mengurasi karya masterpieces tabletop global dengan kualitas komponen vault-grade untuk malam permainan yang tak terlupakan.
            </p>
            <div class="pt-4 flex justify-center space-x-4">
                <a href="/catalog" class="bg-gold-burnished hover:bg-gold-dark text-moss-deep font-bold px-8 py-3.5 rounded-lg text-xs uppercase tracking-wider transition-all duration-300 shadow-lg hover:shadow-gold-burnished/20">
                    Buka Katalog
                </a>
                <a href="/about-us" class="border border-gold-burnished text-gold-burnished hover:bg-gold-burnished hover:text-moss-deep font-bold px-8 py-3.5 rounded-lg text-xs uppercase tracking-wider transition-all duration-300">
                    Jelajahi Toko Kami
                </a>
            </div>
        </div>
    </div>

    <!-- Kinetic Auto-Carousel Section -->
    @if(count($carouselItems) > 0)
        <div class="max-w-7xl mx-auto px-6 space-y-6" wire:poll.4s="nextSlide">
            <div class="flex justify-between items-end border-b border-moss-slate/50 pb-4">
                <div>
                    <span class="text-xs uppercase tracking-widest text-gold-burnished">Spotlight Campaign</span>
                    <h2 class="text-3xl font-serif text-white">Edisi Kolektor Pilihan</h2>
                </div>
                <div class="flex space-x-2">
                    <button wire:click="prevSlide" class="h-10 w-10 border border-moss-emerald/50 hover:border-gold-burnished rounded-full flex items-center justify-center text-gray-400 hover:text-white transition-all">
                        <i class="fa-solid fa-chevron-left text-xs"></i>
                    </button>
                    <button wire:click="nextSlide" class="h-10 w-10 border border-moss-emerald/50 hover:border-gold-burnished rounded-full flex items-center justify-center text-gray-400 hover:text-white transition-all">
                        <i class="fa-solid fa-chevron-right text-xs"></i>
                    </button>
                </div>
            </div>

            <!-- Carousel Display Frame -->
            <div class="relative h-[350px] md:h-[450px] bg-moss-slate border border-moss-emerald/40 rounded-2xl overflow-hidden shadow-2xl flex items-center">
                @foreach($carouselItems as $idx => $item)
                    <div class="absolute inset-0 flex flex-col md:flex-row items-center justify-between p-8 md:p-16 gap-8 transition-opacity duration-1000 {{ $idx == $carouselIndex ? 'opacity-100 z-10' : 'opacity-0 z-0 pointer-events-none' }}">
                        <!-- Details -->
                        <div class="space-y-6 max-w-lg md:text-left text-center">
                            <span class="bg-gold-burnished/10 border border-gold-burnished/30 text-gold-burnished text-[10px] uppercase tracking-wider px-3 py-1 rounded-full font-semibold">
                                Best Selling Strategic Game
                            </span>
                            <h3 class="text-3xl md:text-5xl font-serif text-white tracking-wide leading-tight">{{ $item['name'] }}</h3>
                            <p class="text-xs text-gray-300 font-light leading-relaxed line-clamp-3">
                                {{ $item['description'] }}
                            </p>
                            <div class="flex flex-wrap md:justify-start justify-center gap-4 text-[10px] text-gray-400">
                                <span><i class="fa-regular fa-user text-gold-burnished mr-1"></i> {{ $item['player_count'] }}</span>
                                <span><i class="fa-regular fa-clock text-gold-burnished mr-1"></i> {{ $item['play_time'] }}</span>
                                <span><i class="fa-solid fa-cake-candles text-gold-burnished mr-1"></i> {{ $item['min_age'] }}+ Tahun</span>
                            </div>
                            <div class="pt-4">
                                <a href="/product/{{ $item['slug'] }}" class="inline-block bg-gold-burnished hover:bg-gold-dark text-moss-deep text-xs font-bold uppercase tracking-wider px-6 py-3 rounded-lg transition-colors">
                                    Detail Masterpiece
                                </a>
                            </div>
                        </div>

                        <!-- Graphics Fallback Canvas -->
                        <div class="w-full md:w-1/2 h-full flex items-center justify-center">
                            <div class="w-72 h-72 rounded-2xl bg-gradient-to-tr from-moss-deep via-moss-slate to-moss-emerald border border-moss-emerald/50 flex flex-col items-center justify-center text-center shadow-lg relative p-6">
                                <div class="absolute top-4 right-4 text-xs font-semibold text-gold-burnished uppercase tracking-widest opacity-60">Vault Item</div>
                                <i class="fa-solid fa-puzzle-piece text-5xl text-gold-burnished mb-4 opacity-40 animate-pulse"></i>
                                <span class="text-xl font-serif text-white font-medium tracking-wide leading-tight px-4">{{ $item['name'] }}</span>
                                <span class="text-xs text-gold-burnished mt-2 font-bold">Rp {{ number_format($item['price'], 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Dots Nav -->
            <div class="flex justify-center space-x-2 pt-2">
                @foreach($carouselItems as $idx => $item)
                    <button wire:click="setSlide({{ $idx }})" class="h-2 w-2 rounded-full transition-all duration-300 {{ $idx == $carouselIndex ? 'bg-gold-burnished w-6' : 'bg-moss-slate' }}"></button>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Asymmetric Masterpieces Grid Section -->
    <div class="max-w-7xl mx-auto px-6 space-y-12">
        <div class="border-b border-moss-slate/50 pb-4">
            <span class="text-xs uppercase tracking-widest text-gold-burnished">Curated Excellence</span>
            <h2 class="text-3xl font-serif text-white">Mahakarya Pilihan</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($featuredProducts as $index => $prod)
                <!-- Asymmetric sizing logic for editorial visual interest -->
                <div class="bg-moss-slate/60 border border-moss-slate/80 hover:border-moss-emerald rounded-2xl p-6 transition-all duration-300 flex flex-col justify-between hover:-translate-y-1 group {{ $index % 3 == 0 ? 'md:col-span-2' : 'md:col-span-1' }}">
                    <div class="space-y-4">
                        <!-- Card Image Box -->
                        <div class="aspect-[16/9] w-full rounded-xl bg-moss-deep border border-moss-emerald/20 flex flex-col items-center justify-center text-center relative overflow-hidden group-hover:border-gold-burnished/30 transition-all duration-500">
                            @if($prod->image_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($prod->image_path))
                                <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($prod->image_path) }}" class="h-full w-full object-cover">
                            @else
                                <div class="absolute inset-0 bg-[#2C3A2E] flex flex-col items-center justify-center p-4 text-center">
                                    <i class="fa-solid fa-chess-queen text-3xl text-moss-emerald/30 mb-2"></i>
                                    <span class="text-xs font-serif text-white font-semibold leading-tight max-w-[200px]">{{ $prod->name }}</span>
                                </div>
                            @endif
                            <!-- Meta Badges -->
                            <div class="absolute bottom-2 left-2 flex gap-1.5">
                                <span class="bg-moss-deep/80 text-gold-burnished text-[9px] px-2 py-0.5 rounded border border-gold-burnished/20 uppercase font-semibold">
                                    <i class="fa-solid fa-star text-[8px] mr-1"></i>{{ number_format($prod->rating, 1) }}
                                </span>
                                <span class="bg-moss-deep/80 text-gray-300 text-[9px] px-2 py-0.5 rounded border border-moss-emerald/30 uppercase">
                                    Terjual {{ $prod->sold_count }}
                                </span>
                            </div>
                        </div>

                        <!-- Info -->
                        <div class="space-y-2">
                            <div class="flex justify-between items-start gap-2">
                                <h3 class="text-lg font-serif text-white hover:text-gold-burnished transition-colors duration-300 truncate">
                                    <a href="/product/{{ $prod->slug }}">{{ $prod->name }}</a>
                                </h3>
                            </div>
                            <p class="text-xs text-gray-400 font-light leading-relaxed line-clamp-2">
                                {{ $prod->description }}
                            </p>
                        </div>
                    </div>

                    <!-- Price & Actions -->
                    <div class="pt-6 border-t border-moss-slate/50 mt-6 flex justify-between items-center">
                        <span class="text-sm text-gold-burnished font-bold">Rp {{ number_format($prod->price, 0, ',', '.') }}</span>
                        <a href="/product/{{ $prod->slug }}" class="text-xs uppercase tracking-wider text-gray-400 group-hover:text-gold-burnished font-semibold flex items-center transition-colors">
                            Lihat Karya <i class="fa-solid fa-arrow-right text-[9px] ml-1.5 transform group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Asymmetric New Arrivals Section -->
    <div class="max-w-7xl mx-auto px-6 space-y-12">
        <div class="border-b border-moss-slate/50 pb-4">
            <span class="text-xs uppercase tracking-widest text-gold-burnished">New In The Sanctuary</span>
            <h2 class="text-3xl font-serif text-white">Pendatang Terbaru</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($newArrivals as $prod)
                <div class="bg-moss-slate/40 border border-moss-slate/50 hover:border-moss-emerald rounded-xl p-5 flex flex-col justify-between group hover:-translate-y-1 transition-all duration-300">
                    <div class="space-y-4">
                        <!-- Image Frame -->
                        <div class="aspect-square w-full rounded-lg bg-moss-deep flex flex-col items-center justify-center text-center relative overflow-hidden">
                            @if($prod->image_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($prod->image_path))
                                <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($prod->image_path) }}" class="h-full w-full object-cover">
                            @else
                                <div class="absolute inset-0 bg-[#2C3A2E] flex flex-col items-center justify-center p-4 text-center">
                                    <span class="bg-gold-burnished/10 border border-gold-burnished/30 text-gold-burnished text-[9px] uppercase px-2 py-0.5 rounded absolute top-2 right-2">New Release</span>
                                    <i class="fa-solid fa-box text-2xl text-moss-emerald/20 mb-2"></i>
                                    <span class="text-[10px] font-serif text-white font-medium max-w-[150px]">{{ $prod->name }}</span>
                                </div>
                            @endif
                            <div class="absolute bottom-2 left-2">
                                <span class="bg-moss-deep/90 text-gold-burnished text-[9px] px-2 py-0.5 rounded border border-gold-burnished/20 font-semibold">
                                    <i class="fa-solid fa-star text-[8px] mr-1"></i>{{ number_format($prod->rating, 1) }}
                                </span>
                            </div>
                        </div>

                        <!-- Details -->
                        <div class="space-y-1">
                            <h3 class="text-sm font-serif text-white truncate"><a href="/product/{{ $prod->slug }}">{{ $prod->name }}</a></h3>
                            <p class="text-[10px] text-gray-500 font-light uppercase tracking-wider">{{ $prod->brand->name }}</p>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-moss-slate/50 mt-4 flex items-center justify-between">
                        <span class="text-xs text-white font-bold">Rp {{ number_format($prod->price, 0, ',', '.') }}</span>
                        <a href="/product/{{ $prod->slug }}" class="text-[10px] uppercase font-bold text-gold-burnished hover:text-white transition-colors duration-300">Detail</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- The "Why Us" Statement Grid -->
    <div class="max-w-7xl mx-auto px-6 bg-moss-slate/30 border border-moss-slate/50 rounded-3xl py-12 px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-center divide-y md:divide-y-0 md:divide-x divide-moss-emerald/30">
            <!-- Box 1 -->
            <div class="space-y-4 pt-6 md:pt-0 md:px-4 flex flex-col items-center">
                <div class="h-12 w-12 rounded-full bg-gold-burnished/10 flex items-center justify-center text-gold-burnished">
                    <i class="fa-solid fa-shield-halved text-lg"></i>
                </div>
                <h4 class="text-sm font-semibold text-white uppercase tracking-wider">100% Original Guarantee</h4>
                <p class="text-xs text-gray-400 leading-relaxed font-light">
                    Seluruh produk board game didatangkan langsung dari studio penerbit resmi tanpa perantara ilegal.
                </p>
            </div>
            <!-- Box 2 -->
            <div class="space-y-4 pt-6 md:pt-0 md:px-4 flex flex-col items-center">
                <div class="h-12 w-12 rounded-full bg-gold-burnished/10 flex items-center justify-center text-gold-burnished">
                    <i class="fa-solid fa-box-open text-lg"></i>
                </div>
                <h4 class="text-sm font-semibold text-white uppercase tracking-wider">Vault-Grade Packaging</h4>
                <p class="text-xs text-gray-400 leading-relaxed font-light">
                    Kardus kokoh, bubble wrap tebal, dan pelindung sudut premium demi menjaga kesempurnaan boks game Anda.
                </p>
            </div>
            <!-- Box 3 -->
            <div class="space-y-4 pt-6 md:pt-0 md:px-4 flex flex-col items-center">
                <div class="h-12 w-12 rounded-full bg-gold-burnished/10 flex items-center justify-center text-gold-burnished">
                    <i class="fa-solid fa-chess-board text-lg"></i>
                </div>
                <h4 class="text-sm font-semibold text-white uppercase tracking-wider">Tabletop Approved</h4>
                <p class="text-xs text-gray-400 leading-relaxed font-light">
                    Produk dikurasi oleh tim ahli board game, memastikan nilai re-playability dan kualitas game-play tertinggi.
                </p>
            </div>
            <!-- Box 4 -->
            <div class="space-y-4 pt-6 md:pt-0 md:px-4 flex flex-col items-center">
                <div class="h-12 w-12 rounded-full bg-gold-burnished/10 flex items-center justify-center text-gold-burnished">
                    <i class="fa-solid fa-people-group text-lg"></i>
                </div>
                <h4 class="text-sm font-semibold text-white uppercase tracking-wider">Responsive Guild Support</h4>
                <p class="text-xs text-gray-400 leading-relaxed font-light">
                    Tim dukungan butik kami siap menjawab pertanyaan aturan main dan klaim garansi komponen Anda.
                </p>
            </div>
        </div>
    </div>

</div>
