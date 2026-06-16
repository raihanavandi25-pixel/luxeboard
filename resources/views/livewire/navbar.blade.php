<nav class="fixed top-0 left-0 right-0 z-40 bg-moss-deep/80 backdrop-blur-md border-b border-moss-slate/50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
        
        <!-- Left & Center Left: Brand & Nav Links -->
        <div class="flex items-center min-w-0">
            <!-- Brand Identity Emblem (Far Left) -->
            <a href="/" class="flex-shrink-0 flex flex-col group transition-all duration-500 ease-in-out hover:translate-x-0.5 text-left">
                <span class="text-[9px] tracking-[0.25em] text-[#C5A028] uppercase font-light transition-colors duration-500 ease-in-out group-hover:text-[#D4AF37]">The Tabletop Guild</span>
                <span class="text-2xl font-serif tracking-widest text-white font-bold transition-colors duration-500 ease-in-out group-hover:text-[#D4AF37]">LUXEBOARD</span>
            </a>

            <!-- Subtle Vertical Divider -->
            <div class="border-r border-[#2C3A2E] h-8 mx-6 flex-shrink-0"></div>

            <!-- Navigation Menu Links -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="/catalog" class="relative py-2 text-xs uppercase tracking-widest text-gray-300 hover:text-white font-medium group transition-colors duration-300">
                    All
                    <span class="absolute bottom-0 left-0 w-0 h-[2px] bg-gold-burnished transition-all duration-300 group-hover:w-full"></span>
                </a>
                @foreach($categoriesList as $cat)
                    <a href="/catalog?category={{ $cat->slug }}" class="relative py-2 text-xs uppercase tracking-widest text-gray-300 hover:text-white font-medium group transition-colors duration-300">
                        {{ $cat->name }}
                        <span class="absolute bottom-0 left-0 w-0 h-[2px] bg-gold-burnished transition-all duration-300 group-hover:w-full"></span>
                    </a>
                @endforeach
                <a href="/brands" class="relative py-2 text-xs uppercase tracking-widest text-gray-300 hover:text-white font-medium group transition-colors duration-300">
                    Brands
                    <span class="absolute bottom-0 left-0 w-0 h-[2px] bg-gold-burnished transition-all duration-300 group-hover:w-full"></span>
                </a>
            </div>
        </div>

        <!-- Right Tier (Interactive Toolkit) -->
        <div class="flex items-center justify-end space-x-6 flex-shrink-0">
            
            <!-- Livewire Real-time Search Box -->
            <form wire:submit.prevent="submitSearch" class="relative">
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari karya masterpieces..." 
                       class="w-36 focus:w-64 transition-all duration-500 bg-moss-slate border border-moss-emerald/50 rounded-full px-4 py-2 text-[11px] text-white placeholder-gray-400 focus:outline-none focus:border-gold-burnished focus:ring-1 focus:ring-gold-burnished">
                <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gold-burnished">
                    <i class="fa-solid fa-magnifying-glass text-[10px]"></i>
                </button>
            </form>

            <!-- Notification Hub -->
            <div class="relative group py-2">
                <button class="relative text-gray-300 hover:text-gold-burnished transition-colors duration-300">
                    <i class="fa-regular fa-bell text-base"></i>
                    @if($unreadCount > 0)
                        <span class="absolute -top-1 -right-1 flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                        </span>
                    @endif
                </button>
                
                <!-- Notification Dropdown -->
                <div class="absolute right-0 mt-3 w-80 bg-moss-slate/95 border border-moss-emerald/70 shadow-2xl rounded-xl py-3 opacity-0 translate-y-2 pointer-events-none group-hover:opacity-100 group-hover:translate-y-0 group-hover:pointer-events-auto transition-all duration-300 z-50">
                    <div class="px-4 py-2 border-b border-moss-emerald/30 flex justify-between items-center">
                        <span class="text-xs uppercase tracking-wider text-gold-burnished font-semibold">Notifikasi</span>
                        @if(Auth::check())
                            <a href="/notifications" class="text-[10px] text-gray-400 hover:text-white uppercase font-light">Lihat Semua</a>
                        @endif
                    </div>
                    <div class="max-h-64 overflow-y-auto">
                        @if(!Auth::check())
                            <div class="p-4 text-center text-xs text-gray-400">
                                Silakan <button wire:click="triggerAuth" class="text-gold-burnished font-semibold hover:underline">Masuk</button> untuk melihat notifikasi Anda.
                            </div>
                        @elseif(count($notifications) == 0)
                            <div class="p-4 text-center text-xs text-gray-400 font-light">Tidak ada notifikasi.</div>
                        @else
                            @foreach($notifications as $notif)
                                <div wire:click="markAsRead({{ $notif->id }})" class="p-3 border-b border-moss-emerald/20 hover:bg-moss-deep/50 transition-colors duration-200 cursor-pointer flex gap-3 {{ is_null($notif->read_at) ? 'bg-moss-emerald/10' : '' }}">
                                    <div class="mt-1">
                                        @if($notif->type === 'logistics')
                                            <i class="fa-solid fa-truck-fast text-gold-burnished text-xs"></i>
                                        @else
                                            <i class="fa-solid fa-tag text-gold-burnished text-xs"></i>
                                        @endif
                                    </div>
                                    <div class="space-y-1">
                                        <p class="text-xs text-white font-medium leading-tight">{{ $notif->title }}</p>
                                        <p class="text-[10px] text-gray-400 leading-normal">{{ $notif->message }}</p>
                                        <p class="text-[9px] text-gray-500">{{ $notif->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

            <!-- Wishlist Icon with Hover Preview -->
            <div class="relative group py-2">
                <a href="/cart?tab=wishlist" class="relative text-gray-300 hover:text-gold-burnished transition-colors duration-300">
                    <i class="fa-regular fa-heart text-base"></i>
                    @if($wishlistCount > 0)
                        <span class="absolute -top-1.5 -right-2 bg-gold-burnished text-moss-deep text-[9px] font-bold rounded-full h-4 w-4 flex items-center justify-center border border-moss-deep">
                            {{ $wishlistCount }}
                        </span>
                    @endif
                </a>
                
                <!-- Wishlist Preview Drawer -->
                @if($wishlistCount > 0)
                    <div class="absolute right-0 mt-3 w-72 bg-moss-slate/95 border border-moss-emerald/70 shadow-2xl rounded-xl p-4 opacity-0 translate-y-2 pointer-events-none group-hover:opacity-100 group-hover:translate-y-0 group-hover:pointer-events-auto transition-all duration-300 z-50">
                        <div class="text-[10px] uppercase tracking-wider text-gold-burnished font-semibold pb-2 border-b border-moss-emerald/30 mb-3">Wishlist Preview</div>
                        <div class="space-y-3">
                            @foreach($wishlistPreview as $wItem)
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 bg-moss-deep border border-moss-emerald/30 rounded flex items-center justify-center text-[8px] text-center font-bold text-gray-400 overflow-hidden uppercase flex-shrink-0 relative">
                                        @if($wItem->image_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($wItem->image_path))
                                            <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($wItem->image_path) }}" class="h-full w-full object-cover">
                                        @else
                                            <div class="absolute inset-0 bg-[#2C3A2E] flex items-center justify-center text-[8px] text-white font-bold p-0.5 text-center leading-snug">
                                                {{ substr($wItem->name, 0, 3) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-grow min-w-0">
                                        <p class="text-xs text-white truncate font-medium">{{ $wItem->name }}</p>
                                        <p class="text-[10px] text-gold-burnished">Rp {{ number_format($wItem->price, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <a href="/cart?tab=wishlist" class="block text-center mt-3 text-[10px] uppercase font-semibold text-gold-burnished hover:text-white transition-colors duration-300">Lihat Semua Wishlist</a>
                    </div>
                @endif
            </div>

            <!-- Cart Icon with Hover Preview -->
            <div class="relative group py-2">
                <a href="/cart" class="relative text-gray-300 hover:text-gold-burnished transition-colors duration-300">
                    <i class="fa-regular fa-square-minus text-base transform rotate-90"></i>
                    @if($cartCount > 0)
                        <span class="absolute -top-1.5 -right-2 bg-gold-burnished text-moss-deep text-[9px] font-bold rounded-full h-4 w-4 flex items-center justify-center border border-moss-deep">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>
                
                <!-- Cart Preview Drawer -->
                @if($cartCount > 0)
                    <div class="absolute right-0 mt-3 w-72 bg-moss-slate/95 border border-moss-emerald/70 shadow-2xl rounded-xl p-4 opacity-0 translate-y-2 pointer-events-none group-hover:opacity-100 group-hover:translate-y-0 group-hover:pointer-events-auto transition-all duration-300 z-50">
                        <div class="text-[10px] uppercase tracking-wider text-gold-burnished font-semibold pb-2 border-b border-moss-emerald/30 mb-3">Shopping Cart Preview</div>
                        <div class="space-y-3">
                            @foreach($cartPreview as $cItem)
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 bg-moss-deep border border-moss-emerald/30 rounded flex items-center justify-center text-[8px] text-center font-bold text-gray-400 overflow-hidden uppercase flex-shrink-0 relative">
                                        @if(!empty($cItem['image_path']) && \Illuminate\Support\Facades\Storage::disk('public')->exists($cItem['image_path']))
                                            <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($cItem['image_path']) }}" class="h-full w-full object-cover">
                                        @else
                                            <div class="absolute inset-0 bg-[#2C3A2E] flex items-center justify-center text-[8px] text-white font-bold p-0.5 text-center leading-snug">
                                                {{ substr($cItem['name'], 0, 3) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-grow min-w-0">
                                        <p class="text-xs text-white truncate font-medium">{{ $cItem['name'] }}</p>
                                        <p class="text-[10px] text-gray-400">Qty: {{ $cItem['quantity'] }} &bull; Rp {{ number_format($cItem['price'], 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <a href="/cart" class="block text-center mt-3 text-[10px] uppercase font-semibold text-gold-burnished hover:text-white transition-colors duration-300">Buka Tas Belanja</a>
                    </div>
                @endif
            </div>

            <!-- Profile Vault -->
            <div class="relative group py-2">
                @if(Auth::check())
                    <button class="flex items-center space-x-2 focus:outline-none">
                        <!-- Avatar initials fallback -->
                        <div class="h-8 w-8 rounded-full bg-moss-slate border border-moss-emerald flex items-center justify-center text-xs font-semibold text-gold-burnished uppercase">
                            {{ substr(Auth::user()->name, 0, 2) }}
                        </div>
                    </button>
                    <!-- Logged-in Dropdown Menu -->
                    <div class="absolute right-0 mt-3 w-48 bg-moss-slate/95 border border-moss-emerald/70 shadow-2xl rounded-xl py-2 opacity-0 translate-y-2 pointer-events-none group-hover:opacity-100 group-hover:translate-y-0 group-hover:pointer-events-auto transition-all duration-300 z-50">
                        <div class="px-4 py-2 border-b border-moss-emerald/20 text-xs">
                            <p class="text-white font-medium truncate">{{ Auth::user()->name }}</p>
                            <p class="text-[10px] text-gray-400 truncate">{{ Auth::user()->email }}</p>
                        </div>
                        
                        <!-- High-Contrast Admin Trigger -->
                        @if(Auth::user()->isAdmin())
                            <a href="/admin" class="block px-4 py-2 text-xs text-gold-burnished font-bold bg-gold-burnished/10 hover:bg-gold-burnished hover:text-moss-deep transition-all duration-300 mx-2 my-1 rounded text-center uppercase tracking-wider">
                                Panel Admin
                            </a>
                        @endif

                        <a href="/invoices" class="block px-4 py-2 text-xs text-gray-300 hover:text-gold-burnished transition-colors duration-300"><i class="fa-solid fa-receipt mr-2 w-4"></i> Lacak Pesanan</a>
                        <a href="/cart?tab=wishlist" class="block px-4 py-2 text-xs text-gray-300 hover:text-gold-burnished transition-colors duration-300"><i class="fa-solid fa-heart mr-2 w-4"></i> Wishlist Repo</a>
                        <a href="/cart" class="block px-4 py-2 text-xs text-gray-300 hover:text-gold-burnished transition-colors duration-300"><i class="fa-solid fa-cart-shopping mr-2 w-4"></i> Tas Belanja</a>
                        
                        <div class="border-t border-moss-emerald/20 mt-1 pt-1">
                            <button wire:click="logout" class="w-full text-left px-4 py-2 text-xs text-red-400 hover:text-red-300 transition-colors duration-300"><i class="fa-solid fa-right-from-bracket mr-2 w-4"></i> Keluar</button>
                        </div>
                    </div>
                @else
                    <button wire:click="triggerAuth" class="text-gray-300 hover:text-gold-burnished transition-colors duration-300">
                        <!-- Wireframe Silhouette -->
                        <div class="h-8 w-8 rounded-full bg-moss-slate/50 border border-moss-emerald/40 flex items-center justify-center">
                            <i class="fa-regular fa-user text-xs"></i>
                        </div>
                    </button>
                @endif
            </div>

        </div>

    </div>
</nav>
