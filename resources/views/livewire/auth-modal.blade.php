<div>
    @if($isOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 backdrop-blur-xl bg-moss-deep/75 transition-opacity duration-500 ease-out">
            <!-- Modal Body -->
            <div class="relative bg-moss-slate/90 border border-moss-emerald/50 shadow-2xl rounded-2xl max-w-md w-full p-8 transition-transform duration-500 transform scale-100 space-y-6">
                
                <!-- Close Button -->
                <button wire:click="closeModal" class="absolute top-4 right-4 text-gray-400 hover:text-gold-burnished transition-colors duration-300">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>

                <!-- Header / Logo -->
                <div class="text-center space-y-2">
                    <span class="text-xs uppercase tracking-widest text-gold-burnished font-semibold">AUTHENTICATION GATE</span>
                    <h2 class="text-3xl font-serif text-white tracking-wide">
                        {{ $isRegister ? 'Gabung Guild' : 'Masuk Sanctuary' }}
                    </h2>
                    <p class="text-xs text-gray-400 font-light">
                        {{ $isRegister ? 'Daftarkan diri Anda untuk mengakses butik board game eksklusif.' : 'Gunakan akun Anda untuk melanjutkan transaksi premium.' }}
                    </p>
                </div>

                <!-- Registration success message -->
                @if (session()->has('success_register'))
                    <div class="bg-moss-emerald/30 border border-gold-burnished/50 text-gold-burnished text-xs rounded-lg p-3 text-center">
                        {{ session('success_register') }}
                    </div>
                @endif

                <!-- Toggle Tabs -->
                <div class="flex border-b border-moss-emerald/30">
                    <button wire:click="$set('isRegister', false)" class="flex-1 py-2 text-sm font-medium transition-all duration-300 {{ !$isRegister ? 'text-gold-burnished border-b-2 border-gold-burnished' : 'text-gray-400 hover:text-gray-200' }}">
                        Login
                    </button>
                    <button wire:click="$set('isRegister', true)" class="flex-1 py-2 text-sm font-medium transition-all duration-300 {{ $isRegister ? 'text-gold-burnished border-b-2 border-gold-burnished' : 'text-gray-400 hover:text-gray-200' }}">
                        Daftar Baru
                    </button>
                </div>

                @if(!$isRegister)
                    <!-- Login Form -->
                    <form wire:submit.prevent="login" class="space-y-4">
                        <div class="space-y-1">
                            <label class="text-xs tracking-wider text-gray-400 uppercase">Alamat Email</label>
                            <input type="email" wire:model.defer="login_email" placeholder="nama@email.com" class="w-full bg-moss-deep border border-moss-emerald/50 rounded-lg px-4 py-3 text-sm text-white focus:outline-none focus:border-gold-burnished focus:ring-1 focus:ring-gold-burnished transition-all duration-300">
                            @error('login_email') <span class="text-[11px] text-red-400">{{ $message }}</span> @enderror
                        </div>

                        <div class="space-y-1">
                            <label class="text-xs tracking-wider text-gray-400 uppercase">Kata Sandi</label>
                            <input type="password" wire:model.defer="login_password" placeholder="••••••••" class="w-full bg-moss-deep border border-moss-emerald/50 rounded-lg px-4 py-3 text-sm text-white focus:outline-none focus:border-gold-burnished focus:ring-1 focus:ring-gold-burnished transition-all duration-300">
                            @error('login_password') <span class="text-[11px] text-red-400">{{ $message }}</span> @enderror
                        </div>

                        <button type="submit" class="w-full bg-gold-burnished hover:bg-gold-dark text-moss-deep font-semibold text-sm uppercase py-3 rounded-lg shadow-lg hover:shadow-gold-burnished/20 transition-all duration-300 mt-2">
                            Masuk Ke Sanctuary
                        </button>
                    </form>
                @else
                    <!-- Register Form -->
                    <form wire:submit.prevent="register" class="space-y-4">
                        <div class="space-y-1">
                            <label class="text-xs tracking-wider text-gray-400 uppercase">Nama Lengkap</label>
                            <input type="text" wire:model.defer="reg_name" placeholder="Nama Anda" class="w-full bg-moss-deep border border-moss-emerald/50 rounded-lg px-4 py-3 text-sm text-white focus:outline-none focus:border-gold-burnished focus:ring-1 focus:ring-gold-burnished transition-all duration-300">
                            @error('reg_name') <span class="text-[11px] text-red-400">{{ $message }}</span> @enderror
                        </div>

                        <div class="space-y-1">
                            <label class="text-xs tracking-wider text-gray-400 uppercase">Alamat Email</label>
                            <input type="email" wire:model.defer="reg_email" placeholder="nama@email.com" class="w-full bg-moss-deep border border-moss-emerald/50 rounded-lg px-4 py-3 text-sm text-white focus:outline-none focus:border-gold-burnished focus:ring-1 focus:ring-gold-burnished transition-all duration-300">
                            @error('reg_email') <span class="text-[11px] text-red-400">{{ $message }}</span> @enderror
                        </div>

                        <div class="space-y-1">
                            <label class="text-xs tracking-wider text-gray-400 uppercase">Kata Sandi</label>
                            <input type="password" wire:model.defer="reg_password" placeholder="Minimal 6 karakter" class="w-full bg-moss-deep border border-moss-emerald/50 rounded-lg px-4 py-3 text-sm text-white focus:outline-none focus:border-gold-burnished focus:ring-1 focus:ring-gold-burnished transition-all duration-300">
                            @error('reg_password') <span class="text-[11px] text-red-400">{{ $message }}</span> @enderror
                        </div>

                        <div class="space-y-1">
                            <label class="text-xs tracking-wider text-gray-400 uppercase">Konfirmasi Kata Sandi</label>
                            <input type="password" wire:model.defer="reg_password_confirmation" placeholder="Ketik ulang kata sandi" class="w-full bg-moss-deep border border-moss-emerald/50 rounded-lg px-4 py-3 text-sm text-white focus:outline-none focus:border-gold-burnished focus:ring-1 focus:ring-gold-burnished transition-all duration-300">
                        </div>

                        <button type="submit" class="w-full bg-gold-burnished hover:bg-gold-dark text-moss-deep font-semibold text-sm uppercase py-3 rounded-lg shadow-lg hover:shadow-gold-burnished/20 transition-all duration-300 mt-2">
                            Daftar Sebagai Anggota
                        </button>
                    </form>
                @endif
                
                <!-- Bottom Info -->
                <div class="text-center">
                    <p class="text-[10px] text-gray-500 font-light">
                        Dengan berlanjut, Anda menyetujui Ketentuan Layanan Sanctuary & Guild Keanggotaan Kami.
                    </p>
                </div>
            </div>
        </div>
    @endif
</div>
