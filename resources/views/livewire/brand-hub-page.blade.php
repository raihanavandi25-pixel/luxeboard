<div class="max-w-7xl mx-auto px-6 py-16 space-y-12">
    <!-- Header -->
    <div class="text-center space-y-4">
        <span class="text-xs uppercase tracking-[0.3em] text-gold-burnished font-semibold">Arsip Taksonomi Mekanis</span>
        <h1 class="text-4xl md:text-5xl font-serif text-white font-bold leading-tight">The Editorial Genre Matrix</h1>
        <p class="text-sm text-gray-400 max-w-xl mx-auto font-light leading-relaxed">
            Setiap kategori di bawah ini mewakili ruang simulasi psikologis dan arena strategis yang unik, dikurasi secara ketat berdasarkan kedalaman taktis dan interaksi komponen.
        </p>
    </div>

    <!-- Global Taxonomy Controller Bar -->
    <div class="bg-moss-slate/30 border border-moss-slate/50 backdrop-blur-md rounded-2xl px-6 py-4 flex flex-col md:flex-row items-center justify-between gap-4">
        <!-- Breathing Node Indicator -->
        <div class="flex items-center space-x-3">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-gold-burnished opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-gold-burnished"></span>
            </span>
            <span class="text-[11px] uppercase tracking-widest text-gray-300 font-semibold">
                SYSTEM REGISTRY: {{ $totalFactionsCount }} CATEGORIZED MECHANICAL FACTIONS
            </span>
        </div>

        <!-- Faction Selector Toggles -->
        <div class="flex flex-wrap items-center gap-2">
            <button wire:click="selectFaction('All')" 
                    class="px-4 py-2 text-[10px] uppercase tracking-wider font-semibold rounded-lg border transition-all duration-300 
                    {{ $selectedGenre === 'All' ? 'bg-gold-burnished text-moss-deep border-gold-burnished font-bold shadow-lg shadow-gold-burnished/10' : 'text-gray-400 hover:text-white bg-moss-deep/40 border-moss-slate/50 hover:border-gold-burnished/30' }}">
                All Factions
            </button>
            <button wire:click="selectFaction('Grand Strategy & Economy')" 
                    class="px-4 py-2 text-[10px] uppercase tracking-wider font-semibold rounded-lg border transition-all duration-300 
                    {{ $selectedGenre === 'Grand Strategy & Economy' ? 'bg-gold-burnished text-moss-deep border-gold-burnished font-bold shadow-lg shadow-gold-burnished/10' : 'text-gray-400 hover:text-white bg-moss-deep/40 border-moss-slate/50 hover:border-gold-burnished/30' }}">
                Grand Strategy & Economy
            </button>
            <button wire:click="selectFaction('Social Psychology & Party')" 
                    class="px-4 py-2 text-[10px] uppercase tracking-wider font-semibold rounded-lg border transition-all duration-300 
                    {{ $selectedGenre === 'Social Psychology & Party' ? 'bg-gold-burnished text-moss-deep border-gold-burnished font-bold shadow-lg shadow-gold-burnished/10' : 'text-gray-400 hover:text-white bg-moss-deep/40 border-moss-slate/50 hover:border-gold-burnished/30' }}">
                Social Psychology & Party
            </button>
            <button wire:click="selectFaction('Tactical Survival')" 
                    class="px-4 py-2 text-[10px] uppercase tracking-wider font-semibold rounded-lg border transition-all duration-300 
                    {{ $selectedGenre === 'Tactical Survival' ? 'bg-gold-burnished text-moss-deep border-gold-burnished font-bold shadow-lg shadow-gold-burnished/10' : 'text-gray-400 hover:text-white bg-moss-deep/40 border-moss-slate/50 hover:border-gold-burnished/30' }}">
                Tactical Survival
            </button>
        </div>
    </div>

    <!-- Editorial Asymmetric Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        @foreach($genreData as $genre)
            <div class="transition-all duration-500 ease-out transform animate-fade-in" wire:key="genre-{{ $genre['id'] }}">
                @if($genre['product_count'] == 0)
                    <!-- Minimal Text-Centered Placeholder Card for Empty Inventory -->
                    <div class="bg-moss-deep/40 border border-dashed border-moss-slate rounded-3xl p-8 flex flex-col items-center justify-center text-center h-64 space-y-4">
                        <i class="fa-solid fa-box-archive text-3xl text-moss-slate"></i>
                        <div class="space-y-1">
                            <span class="text-xs uppercase tracking-widest text-moss-emerald font-semibold">{{ $genre['title'] }}</span>
                            <h3 class="text-sm font-mono text-gray-500">Vault Empty: Allocating New Manifests</h3>
                        </div>
                    </div>
                @else
                    <!-- Editorial Uniform High-Contrast Structural Container -->
                    <div class="bg-gradient-to-br {{ $genre['bg_gradient'] }} border border-moss-slate/80 hover:border-gold-burnished/50 rounded-3xl p-8 flex flex-col justify-between h-64 transition-all duration-300 hover:-translate-y-1 group relative overflow-hidden shadow-xl">
                        <!-- Absolut-positioned Architectural Tag -->
                        <span class="absolute top-6 right-6 bg-gold-burnished/10 border border-gold-burnished/30 text-gold-burnished text-[9px] uppercase tracking-widest px-2.5 py-1 rounded font-semibold">
                            {{ $genre['tag'] }}
                        </span>

                        <div class="space-y-4 max-w-[80%]">
                            <div class="space-y-1">
                                <span class="text-[10px] uppercase tracking-widest text-gold-burnished/70 font-semibold">{{ $genre['faction'] }}</span>
                                <h3 class="text-2xl font-serif text-white font-semibold leading-tight group-hover:text-gold-burnished transition-colors duration-300">
                                    {{ $genre['title'] }}
                                </h3>
                            </div>
                            <!-- Curator's Abstract -->
                            <p class="text-xs text-gray-300 font-light leading-relaxed line-clamp-2">
                                {{ $genre['abstract'] }}
                            </p>
                        </div>

                        <!-- Deep Link Action with Responsive Micro-Translation Arrow -->
                        <div class="pt-4 border-t border-moss-slate/50 flex justify-between items-center">
                            <span class="text-[10px] text-gray-400 font-mono">MANIFEST COUNT: {{ $genre['product_count'] }} ACTIVE ITEMS</span>
                            <a href="{{ $genre['catalog_link'] }}" class="text-[11px] uppercase tracking-widest text-gold-burnished group-hover:text-white font-bold flex items-center transition-colors duration-300">
                                Masuki Arena Taktis 
                                <i class="fa-solid fa-arrow-right text-[10px] ml-1.5 transform group-hover:translate-x-1 transition-transform duration-300"></i>
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</div>
