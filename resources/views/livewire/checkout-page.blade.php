<div class="max-w-7xl mx-auto px-6 py-12">
    <div class="text-center space-y-2 mb-12">
        <span class="text-xs uppercase tracking-[0.25em] text-gold-burnished font-semibold">Secure Checkout</span>
        <h1 class="text-4xl font-serif text-white font-bold">Langkah Pembayaran</h1>
    </div>

    <!-- Stock Error message -->
    @error('cart')
        <div class="bg-red-500/20 border border-red-500 text-red-300 p-4 rounded-xl mb-8 text-sm">
            {{ $message }}
        </div>
    @enderror

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        
        <!-- Left: Form Shipping & Payment -->
        <div class="lg:col-span-2 space-y-8">
            
            <!-- Shipping Details Form -->
            <div class="bg-moss-slate/30 border border-moss-slate/50 rounded-2xl p-8 space-y-6">
                <h2 class="text-lg font-serif text-white border-b border-moss-emerald/20 pb-3 flex items-center">
                    <i class="fa-solid fa-truck text-gold-burnished mr-3"></i> Detail Pengiriman
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="space-y-1">
                        <label class="text-xs uppercase tracking-wider text-gray-400">Nama Penerima</label>
                        <input type="text" wire:model.defer="recipient_name" placeholder="Nama Lengkap" class="w-full bg-moss-deep border border-moss-emerald/50 rounded-lg px-4 py-3 text-sm text-white focus:outline-none focus:border-gold-burnished focus:ring-1 focus:ring-gold-burnished transition-all">
                        @error('recipient_name') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs uppercase tracking-wider text-gray-400">No. Telepon / WhatsApp</label>
                        <input type="tel" wire:model.defer="recipient_phone" placeholder="Contoh: 08123456789" class="w-full bg-moss-deep border border-moss-emerald/50 rounded-lg px-4 py-3 text-sm text-white focus:outline-none focus:border-gold-burnished focus:ring-1 focus:ring-gold-burnished transition-all">
                        @error('recipient_phone') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="text-xs uppercase tracking-wider text-gray-400">Alamat Lengkap Pengiriman</label>
                    <textarea wire:model.defer="shipping_address" rows="4" placeholder="Tuliskan alamat lengkap beserta detail patokan..." class="w-full bg-moss-deep border border-moss-emerald/50 rounded-lg px-4 py-3 text-sm text-white focus:outline-none focus:border-gold-burnished focus:ring-1 focus:ring-gold-burnished transition-all"></textarea>
                    @error('shipping_address') <span class="text-xs text-red-400">{{ $message }}</span> @enderror
                </div>

                <!-- Graded Shipping Tiers -->
                <div class="space-y-2">
                    <label class="text-xs uppercase tracking-wider text-gray-400">Pilih Layanan Kurir</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <label class="bg-moss-deep border rounded-xl p-4 flex justify-between items-center cursor-pointer hover:border-gold-burnished transition-all {{ $shipping_tier === 'Regular' ? 'border-gold-burnished ring-1 ring-gold-burnished' : 'border-moss-emerald/40' }}">
                            <div class="flex items-center">
                                <input type="radio" wire:model.live="shipping_tier" value="Regular" class="accent-gold-burnished mr-3">
                                <div class="text-left">
                                    <p class="text-xs font-semibold text-white">Regular Standard</p>
                                    <p class="text-[10px] text-gray-400">Estimasi tiba 2-3 hari</p>
                                </div>
                            </div>
                            <span class="text-xs text-gold-burnished font-bold">Rp 20.000</span>
                        </label>

                        <label class="bg-moss-deep border rounded-xl p-4 flex justify-between items-center cursor-pointer hover:border-gold-burnished transition-all {{ $shipping_tier === 'Same Day' ? 'border-gold-burnished ring-1 ring-gold-burnished' : 'border-moss-emerald/40' }}">
                            <div class="flex items-center">
                                <input type="radio" wire:model.live="shipping_tier" value="Same Day" class="accent-gold-burnished mr-3">
                                <div class="text-left">
                                    <p class="text-xs font-semibold text-white">Same Day Premium</p>
                                    <p class="text-[10px] text-gray-400">Estimasi tiba hari yang sama</p>
                                </div>
                            </div>
                            <span class="text-xs text-gold-burnished font-bold">Rp 50.000</span>
                        </label>

                        <label class="bg-moss-deep border rounded-xl p-4 flex justify-between items-center cursor-pointer hover:border-gold-burnished transition-all {{ $shipping_tier === 'Instant Next Day' ? 'border-gold-burnished ring-1 ring-gold-burnished' : 'border-moss-emerald/40' }}">
                            <div class="flex items-center">
                                <input type="radio" wire:model.live="shipping_tier" value="Instant Next Day" class="accent-gold-burnished mr-3">
                                <div class="text-left">
                                    <p class="text-xs font-semibold text-white">Instant Next Day</p>
                                    <p class="text-[10px] text-gray-400">Besok pagi sampai garansi</p>
                                </div>
                            </div>
                            <span class="text-xs text-gold-burnished font-bold">Rp 100.000</span>
                        </label>

                        <label class="bg-moss-deep border rounded-xl p-4 flex justify-between items-center cursor-pointer hover:border-gold-burnished transition-all {{ $shipping_tier === 'Instant Priority Next Day' ? 'border-gold-burnished ring-1 ring-gold-burnished' : 'border-moss-emerald/40' }}">
                            <div class="flex items-center">
                                <input type="radio" wire:model.live="shipping_tier" value="Instant Priority Next Day" class="accent-gold-burnished mr-3">
                                <div class="text-left">
                                    <p class="text-xs font-semibold text-white">Luxury Priority</p>
                                    <p class="text-[10px] text-gray-400">Pengiriman VVIP Prioritas</p>
                                </div>
                            </div>
                            <span class="text-xs text-gold-burnished font-bold">Rp 200.000</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Payment Methods Selection -->
            <div class="bg-moss-slate/30 border border-moss-slate/50 rounded-2xl p-8 space-y-6">
                <h2 class="text-lg font-serif text-white border-b border-moss-emerald/20 pb-3 flex items-center">
                    <i class="fa-solid fa-credit-card text-gold-burnished mr-3"></i> Metode Pembayaran
                </h2>

                <div class="space-y-4">
                    <!-- QRIS -->
                    <label class="bg-moss-deep border rounded-xl p-4 flex flex-col cursor-pointer hover:border-gold-burnished transition-all {{ $payment_method === 'QRIS' ? 'border-gold-burnished ring-1 ring-gold-burnished' : 'border-moss-emerald/40' }}">
                        <div class="flex items-center justify-between w-full">
                            <div class="flex items-center">
                                <input type="radio" wire:model.live="payment_method" value="QRIS" class="accent-gold-burnished mr-3">
                                <span class="text-xs font-semibold text-white">QRIS (Otomatis & Cepat)</span>
                            </div>
                            <span class="bg-gold-burnished/10 border border-gold-burnished/30 text-gold-burnished text-[9px] px-2 py-0.5 rounded font-semibold uppercase">10 Menit Expiry</span>
                        </div>
                        <p class="text-[10px] text-gray-400 mt-2 pl-6">
                            Pindai kode QR dinamis yang akan dibuat di halaman berikutnya. Masa kedaluwarsa ketat 10 menit demi sinkronisasi stok board game Anda.
                        </p>
                    </label>

                    <!-- Bank Transfer / Debit Card -->
                    <label class="bg-moss-deep border rounded-xl p-4 flex flex-col cursor-pointer hover:border-gold-burnished transition-all {{ $payment_method === 'Bank Transfer' ? 'border-gold-burnished ring-1 ring-gold-burnished' : 'border-moss-emerald/40' }}">
                        <div class="flex items-center justify-between w-full">
                            <div class="flex items-center">
                                <input type="radio" wire:model.live="payment_method" value="Bank Transfer" class="accent-gold-burnished mr-3">
                                <span class="text-xs font-semibold text-white">Bank Transfer / Virtual Account</span>
                            </div>
                            <span class="bg-moss-slate border border-moss-emerald/50 text-gray-300 text-[9px] px-2 py-0.5 rounded uppercase">24 Jam Expiry</span>
                        </div>
                        <p class="text-[10px] text-gray-400 mt-2 pl-6">
                            Transfer dana via Mandiri/BCA/BTI virtual account. Batas penyelesaian transaksi adalah 24 jam sebelum slot dibatalkan otomatis.
                        </p>
                    </label>

                    <!-- COD -->
                    <label class="bg-moss-deep border rounded-xl p-4 flex flex-col cursor-pointer hover:border-gold-burnished transition-all {{ $payment_method === 'COD' ? 'border-gold-burnished ring-1 ring-gold-burnished' : 'border-moss-emerald/40' }}">
                        <div class="flex items-center justify-between w-full">
                            <div class="flex items-center">
                                <input type="radio" wire:model.live="payment_method" value="COD" class="accent-gold-burnished mr-3">
                                <span class="text-xs font-semibold text-white">Cash On Delivery (COD)</span>
                            </div>
                            <span class="bg-moss-slate border border-moss-emerald/50 text-gray-400 text-[9px] px-2 py-0.5 rounded uppercase">Tanpa Batas Waktu</span>
                        </div>
                        <p class="text-[10px] text-gray-400 mt-2 pl-6">
                            Lakukan pembayaran tunai kepada kurir saat boks board game tiba di depan pintu Anda.
                        </p>
                    </label>
                </div>
            </div>

        </div>

        <!-- Right: Invoice Order Summary -->
        <div class="space-y-8">
            <div class="bg-moss-slate/40 border border-moss-slate/50 rounded-2xl p-6 space-y-6">
                <h3 class="text-xs uppercase tracking-widest text-gold-burnished font-semibold pb-2 border-b border-moss-emerald/30">Ringkasan Tas</h3>
                
                <div class="space-y-4 max-h-60 overflow-y-auto">
                    @foreach($cart as $productId => $item)
                        <div class="flex justify-between items-center gap-3">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="h-10 w-10 bg-moss-deep border border-moss-emerald/30 rounded flex items-center justify-center text-[8px] font-bold text-gray-400 uppercase overflow-hidden flex-shrink-0 relative">
                                    @if(!empty($item['image_path']) && \Illuminate\Support\Facades\Storage::disk('public')->exists($item['image_path']))
                                        <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($item['image_path']) }}" class="h-full w-full object-cover">
                                    @else
                                        <div class="absolute inset-0 bg-[#2C3A2E] flex items-center justify-center text-[8px] text-white font-bold p-0.5 text-center leading-snug">
                                            {{ substr($item['name'], 0, 3) }}
                                        </div>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <p class="text-xs text-white truncate font-medium max-w-[120px]">{{ $item['name'] }}</p>
                                    <p class="text-[10px] text-gray-400">Qty: {{ $item['quantity'] }}</p>
                                </div>
                            </div>
                            <span class="text-xs text-white font-medium flex-shrink-0">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="border-t border-moss-emerald/20 pt-4 space-y-3">
                    <div class="flex justify-between text-xs text-gray-400">
                        <span>Subtotal Produk</span>
                        <span class="text-white">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-xs text-gray-400">
                        <span>Biaya Kurir ({{ $shipping_tier }})</span>
                        <span class="text-white">Rp {{ number_format($shippingFee, 0, ',', '.') }}</span>
                    </div>
                    <div class="border-t border-moss-emerald/25 pt-4 flex justify-between items-baseline">
                        <span class="text-xs uppercase tracking-wider text-gray-300">Total Pembayaran</span>
                        <span class="text-lg font-serif text-gold-burnished font-bold">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                </div>

                <button wire:click="placeOrder" class="w-full bg-gold-burnished hover:bg-gold-dark text-moss-deep font-bold text-xs uppercase tracking-wider py-4 rounded-xl shadow-lg hover:shadow-gold-burnished/20 transition-all">
                    Selesaikan Pesanan &rarr;
                </button>
            </div>
        </div>

    </div>
</div>
