<div class="max-w-7xl mx-auto px-6 py-16 space-y-16">
    <div class="border-b border-moss-slate/50 pb-6">
        <span class="text-xs uppercase tracking-[0.3em] text-gold-burnished font-semibold">Get in Touch</span>
        <h1 class="text-4xl font-serif text-white font-bold mt-2">Hubungi Tim Kurator Kami</h1>
        <p class="text-sm text-gray-400 font-light mt-1">Kami siap menjawab pertanyaan Anda mengenai produk, ketersediaan vault, dan pemesanan khusus.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        <!-- Contact Form Card -->
        <div class="lg:col-span-2 bg-moss-slate/30 border border-moss-slate/50 rounded-3xl p-8 md:p-12 space-y-6">
            @if(session()->has('contact_success'))
                <div class="bg-moss-emerald/20 border border-moss-emerald/50 rounded-2xl p-6 text-center space-y-3">
                    <i class="fa-solid fa-circle-check text-4xl text-gold-burnished"></i>
                    <p class="text-sm text-white font-medium">{{ session('contact_success') }}</p>
                </div>
            @else
                <form wire:submit.prevent="send" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Name -->
                        <div class="space-y-2">
                            <label class="text-xs uppercase tracking-wider text-gray-300 font-medium">Nama Lengkap</label>
                            <input type="text" wire:model.blur="name" class="w-full bg-moss-deep border border-moss-slate/60 focus:border-gold-burnished rounded-xl px-4 py-3 text-sm text-white focus:outline-none transition-colors" placeholder="Masukkan nama Anda">
                            @error('name') <span class="text-xs text-red-500 font-light">{{ $message }}</span> @enderror
                        </div>

                        <!-- Email -->
                        <div class="space-y-2">
                            <label class="text-xs uppercase tracking-wider text-gray-300 font-medium">Alamat Email</label>
                            <input type="email" wire:model.blur="email" class="w-full bg-moss-deep border border-moss-slate/60 focus:border-gold-burnished rounded-xl px-4 py-3 text-sm text-white focus:outline-none transition-colors" placeholder="nama@email.com">
                            @error('email') <span class="text-xs text-red-500 font-light">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Phone -->
                        <div class="space-y-2">
                            <label class="text-xs uppercase tracking-wider text-gray-300 font-medium">Nomor Handphone</label>
                            <input type="text" wire:model.blur="phone" class="w-full bg-moss-deep border border-moss-slate/60 focus:border-gold-burnished rounded-xl px-4 py-3 text-sm text-white focus:outline-none transition-colors" placeholder="081234567890">
                            @error('phone') <span class="text-xs text-red-500 font-light">{{ $message }}</span> @enderror
                        </div>

                        <!-- Category -->
                        <div class="space-y-2">
                            <label class="text-xs uppercase tracking-wider text-gray-300 font-medium">Kategori Pertanyaan</label>
                            <select wire:model.blur="category" class="w-full bg-moss-deep border border-moss-slate/60 focus:border-gold-burnished rounded-xl px-4 py-3 text-sm text-white focus:outline-none transition-colors">
                                <option value="">Pilih kategori...</option>
                                <option value="sales">Pertanyaan Pembelian</option>
                                <option value="rules">Bantuan Aturan Permainan</option>
                                <option value="partnership">Kemitraan Studio</option>
                                <option value="general">Lain-lain</option>
                            </select>
                            @error('category') <span class="text-xs text-red-500 font-light">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Message -->
                    <div class="space-y-2">
                        <label class="text-xs uppercase tracking-wider text-gray-300 font-medium">Pesan</label>
                        <textarea wire:model.blur="message" rows="5" class="w-full bg-moss-deep border border-moss-slate/60 focus:border-gold-burnished rounded-xl px-4 py-3 text-sm text-white focus:outline-none transition-colors resize-none" placeholder="Tuliskan pesan Anda di sini..."></textarea>
                        @error('message') <span class="text-xs text-red-500 font-light">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="w-full bg-gold-burnished hover:bg-gold-dark text-moss-deep font-bold px-6 py-4 rounded-xl text-xs uppercase tracking-widest transition-colors duration-300">
                        Kirim Pesan <i class="fa-solid fa-paper-plane ml-2"></i>
                    </button>
                </form>
            @endif
        </div>

        <!-- Sidebar / FAQs / Help Cards -->
        <div class="space-y-8">
            <div class="bg-moss-slate/20 border border-moss-slate/40 rounded-2xl p-6 space-y-4">
                <h3 class="text-sm font-semibold text-white uppercase tracking-wider">Respons Cepat</h3>
                <p class="text-xs text-gray-400 font-light leading-relaxed">
                    Tim dukungan butik kami akan membalas seluruh tiket keluhan dan konsultasi dalam waktu maksimal 1x24 jam pada hari kerja.
                </p>
            </div>

            <div id="faq" class="scroll-mt-24 space-y-4">
                <h3 class="text-sm font-semibold text-white uppercase tracking-wider">Pertanyaan Umum (FAQ)</h3>
                <div class="space-y-3">
                    <div class="bg-moss-slate/10 border border-moss-slate/30 rounded-xl p-4 space-y-1">
                        <h4 class="text-xs font-semibold text-white">Apakah semua produk ready stock?</h4>
                        <p class="text-[11px] text-gray-400 font-light">
                            Ya, seluruh produk berlabel "Tersedia" di catalog kami dipastikan ready stock di butik fisik Jakarta.
                        </p>
                    </div>
                    <div class="bg-moss-slate/10 border border-moss-slate/30 rounded-xl p-4 space-y-1">
                        <h4 class="text-xs font-semibold text-white">Bagaimana garansi komponen rusak?</h4>
                        <p class="text-[11px] text-gray-400 font-light">
                            Kami menyediakan garansi klaim komponen hilang atau rusak langsung ke studio penerbit asal.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
