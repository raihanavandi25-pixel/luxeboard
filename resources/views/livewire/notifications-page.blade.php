<div class="max-w-7xl mx-auto px-6 py-12 space-y-10">

    <!-- Header -->
    <div class="flex justify-between items-end border-b border-moss-slate/50 pb-6">
        <div class="space-y-2">
            <span class="text-xs uppercase tracking-[0.3em] text-gold-burnished font-semibold">Notification Hub</span>
            <h1 class="text-4xl font-serif text-white font-bold">Pusat Notifikasi</h1>
        </div>
        @if(count($notifications) > 0)
            <button wire:click="markAllRead" class="text-xs uppercase tracking-wider text-gold-burnished hover:text-white font-semibold transition-colors border border-gold-burnished/30 hover:bg-gold-burnished hover:text-moss-deep px-4 py-2 rounded-lg">
                Tandai Semua Dibaca
            </button>
        @endif
    </div>

    <!-- Notifications List -->
    @if(count($notifications) == 0)
        <div class="bg-moss-slate/20 border border-moss-slate/40 rounded-2xl p-16 text-center text-gray-400 font-light space-y-4">
            <i class="fa-regular fa-bell-slash text-5xl text-moss-emerald/20"></i>
            <p class="text-sm">Anda belum memiliki notifikasi.</p>
        </div>
    @else
        <div class="space-y-4">
            @foreach($notifications as $notif)
                <div wire:click="markAsRead({{ $notif->id }})"
                     class="bg-moss-slate/30 border rounded-2xl p-6 flex items-start gap-5 cursor-pointer transition-all duration-300 hover:border-gold-burnished/40 hover:-translate-y-0.5 group
                     {{ is_null($notif->read_at) ? 'border-gold-burnished/30 bg-moss-slate/50' : 'border-moss-slate/50' }}">

                    <!-- Icon -->
                    <div class="flex-shrink-0 h-10 w-10 rounded-full flex items-center justify-center
                        {{ $notif->type === 'promo' ? 'bg-gold-burnished/10 text-gold-burnished' : ($notif->type === 'logistics' ? 'bg-blue-500/10 text-blue-400' : 'bg-moss-emerald/10 text-moss-emerald') }}">
                        @if($notif->type === 'promo')
                            <i class="fa-solid fa-tag"></i>
                        @elseif($notif->type === 'logistics')
                            <i class="fa-solid fa-truck-fast"></i>
                        @else
                            <i class="fa-solid fa-percent"></i>
                        @endif
                    </div>

                    <!-- Content -->
                    <div class="flex-grow space-y-1.5 min-w-0">
                        <div class="flex justify-between items-start gap-4">
                            <h3 class="text-sm font-semibold text-white group-hover:text-gold-burnished transition-colors leading-snug">{{ $notif->title }}</h3>
                            @if(is_null($notif->read_at))
                                <span class="flex-shrink-0 h-2.5 w-2.5 rounded-full bg-red-500 mt-1.5 animate-pulse"></span>
                            @endif
                        </div>
                        <p class="text-xs text-gray-400 font-light leading-relaxed">{{ $notif->message }}</p>
                        <p class="text-[10px] text-gray-500">{{ $notif->created_at->diffForHumans() }}</p>
                    </div>

                    <!-- Chevron -->
                    <div class="flex-shrink-0 text-gray-500 group-hover:text-gold-burnished transition-colors">
                        <i class="fa-solid fa-chevron-right text-xs"></i>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
