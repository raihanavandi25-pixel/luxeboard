<div class="max-w-7xl mx-auto px-6 py-12" wire:poll.1s="calculateTimeLeft">
    
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-10">
        
        <!-- Left: Invoices List Sidebar -->
        <div class="lg:col-span-1 space-y-6">
            <h3 class="text-xs uppercase tracking-widest text-gold-burnished font-semibold px-2">Daftar Faktur</h3>
            
            <div class="space-y-3 max-h-[500px] overflow-y-auto pr-2">
                @if(count($orders) == 0)
                    <p class="text-xs text-gray-500 italic p-2">Tidak ada riwayat transaksi.</p>
                @else
                    @foreach($orders as $o)
                        <button wire:click="selectInvoice('{{ $o->order_number }}')" 
                                class="w-full text-left bg-moss-slate/30 border p-4 rounded-xl transition-all duration-300 hover:border-gold-burnished/50 flex flex-col gap-2 {{ $orderNumber === $o->order_number ? 'border-gold-burnished bg-moss-slate/50' : 'border-moss-slate/50' }}">
                            <div class="flex justify-between items-center w-full">
                                <span class="text-xs font-semibold text-white font-serif">{{ $o->order_number }}</span>
                                @if($o->status === 'Created')
                                    <span class="text-[9px] uppercase px-2 py-0.5 rounded bg-blue-500/20 text-blue-300 font-bold border border-blue-500/30">Created</span>
                                @elseif($o->status === 'Paid')
                                    <span class="text-[9px] uppercase px-2 py-0.5 rounded bg-yellow-500/20 text-yellow-300 font-bold border border-yellow-500/30">Paid</span>
                                @elseif($o->status === 'Shipped')
                                    <span class="text-[9px] uppercase px-2 py-0.5 rounded bg-purple-500/20 text-purple-300 font-bold border border-purple-500/30">Shipped</span>
                                @elseif($o->status === 'Completed')
                                    <span class="text-[9px] uppercase px-2 py-0.5 rounded bg-green-500/20 text-green-300 font-bold border border-green-500/30">Completed</span>
                                @elseif($o->status === 'Cancelled')
                                    <span class="text-[9px] uppercase px-2 py-0.5 rounded bg-red-500/20 text-red-300 font-bold border border-red-500/30">Cancelled</span>
                                @endif
                            </div>
                            <div class="flex justify-between items-center text-[10px] text-gray-400 w-full font-light">
                                <span>{{ $o->created_at->format('d M Y') }}</span>
                                <span class="font-bold text-gray-300">Rp {{ number_format($o->total_amount, 0, ',', '.') }}</span>
                            </div>
                        </button>
                    @endforeach
                @endif
            </div>
        </div>

        <!-- Right: Invoice Detailed View -->
        <div class="lg:col-span-3">
            @if(session()->has('simulation_msg'))
                <div class="bg-gold-burnished/20 border border-gold-burnished/60 text-gold-burnished p-4 rounded-xl mb-6 text-sm font-semibold">
                    {{ session('simulation_msg') }}
                </div>
            @endif

            @if(!$selectedOrder)
                <!-- Detail Placeholder -->
                <div class="bg-moss-slate/10 border border-moss-slate/40 rounded-2xl p-16 text-center text-gray-500 font-light space-y-4 h-full flex flex-col items-center justify-center min-h-[400px]">
                    <i class="fa-solid fa-file-invoice-dollar text-6xl text-moss-emerald/20"></i>
                    <p class="text-sm">Pilih salah satu nomor faktur di samping untuk melacak detail transaksi Anda.</p>
                </div>
            @else
                <div class="bg-moss-slate/30 border border-moss-slate/50 rounded-2xl p-8 space-y-8">
                    
                    <!-- Title & Header -->
                    <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4 pb-6 border-b border-moss-emerald/20">
                        <div class="space-y-1">
                            <span class="text-[10px] uppercase tracking-widest text-gold-burnished font-semibold">Faktur Penjualan</span>
                            <h2 class="text-2xl font-serif text-white font-bold">{{ $selectedOrder->order_number }}</h2>
                            <p class="text-xs text-gray-400">Dibuat pada {{ $selectedOrder->created_at->format('d F Y H:i') }} WIB</p>
                        </div>
                        <div class="text-left sm:text-right">
                            <span class="text-[10px] uppercase tracking-wider text-gray-400 block">Total Tagihan</span>
                            <span class="text-xl font-serif text-gold-burnished font-bold">Rp {{ number_format($selectedOrder->total_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <!-- Chronological State Tracker Timeline -->
                    <div class="space-y-3">
                        <h4 class="text-xs uppercase tracking-widest text-gold-burnished font-semibold">Status Pengiriman & Pesanan</h4>
                        
                        @if($selectedOrder->status === 'Cancelled')
                            <div class="bg-red-500/10 border border-red-500/30 text-red-300 text-xs rounded-xl p-4 flex items-center">
                                <i class="fa-solid fa-circle-xmark text-lg mr-3"></i>
                                <div>
                                    <p class="font-bold">Pesanan Telah Dibatalkan</p>
                                    <p class="text-[10px] text-gray-400 font-light">
                                        Faktur dibatalkan pada {{ $selectedOrder->cancelled_at ? $selectedOrder->cancelled_at->format('d F Y H:i') : $selectedOrder->updated_at->format('d F Y H:i') }} WIB.
                                    </p>
                                </div>
                            </div>
                        @else
                            <!-- Horizontal Progress Bar -->
                            <div class="grid grid-cols-4 gap-2 text-center pt-2">
                                <!-- Step 1: Created -->
                                <div class="space-y-2">
                                    <div class="h-2 rounded bg-gold-burnished shadow shadow-gold-burnished/20"></div>
                                    <p class="text-[10px] font-bold text-white uppercase">Created</p>
                                    <p class="text-[9px] text-gray-400 font-light">Pesanan Diterima</p>
                                </div>

                                <!-- Step 2: Paid -->
                                <div class="space-y-2">
                                    <div class="h-2 rounded {{ in_array($selectedOrder->status, ['Paid', 'Shipped', 'Completed']) ? 'bg-gold-burnished' : 'bg-moss-deep' }}"></div>
                                    <p class="text-[10px] font-bold {{ in_array($selectedOrder->status, ['Paid', 'Shipped', 'Completed']) ? 'text-white' : 'text-gray-500' }} uppercase">Paid</p>
                                    <p class="text-[9px] text-gray-400 font-light">Terverifikasi</p>
                                </div>

                                <!-- Step 3: Shipped -->
                                <div class="space-y-2">
                                    <div class="h-2 rounded {{ in_array($selectedOrder->status, ['Shipped', 'Completed']) ? 'bg-gold-burnished' : 'bg-moss-deep' }}"></div>
                                    <p class="text-[10px] font-bold {{ in_array($selectedOrder->status, ['Shipped', 'Completed']) ? 'text-white' : 'text-gray-500' }} uppercase">Shipped</p>
                                    <p class="text-[9px] text-gray-400 font-light">Dalam Perjalanan</p>
                                </div>

                                <!-- Step 4: Completed -->
                                <div class="space-y-2">
                                    <div class="h-2 rounded {{ $selectedOrder->status === 'Completed' ? 'bg-gold-burnished' : 'bg-moss-deep' }}"></div>
                                    <p class="text-[10px] font-bold {{ $selectedOrder->status === 'Completed' ? 'text-white' : 'text-gray-500' }} uppercase">Completed</p>
                                    <p class="text-[9px] text-gray-400 font-light">
                                        @if($selectedOrder->delivered_at)
                                            Tiba: {{ $selectedOrder->delivered_at->format('d/m H:i') }}
                                        @else
                                            Tiba di Tujuan
                                        @endif
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Payment Details with Expiration Clocks -->
                    @if($selectedOrder->status === 'Created')
                        <div class="bg-moss-deep border border-moss-emerald/40 rounded-2xl p-6 grid grid-cols-1 md:grid-cols-3 gap-6 items-center">
                            
                            <!-- Timer -->
                            <div class="text-center md:text-left space-y-1">
                                <span class="text-[10px] uppercase text-gray-400 tracking-wider">Sisa Waktu Pembayaran</span>
                                @if($timeLeftString === 'EXPIRED')
                                    <p class="text-xl font-bold text-red-500 uppercase tracking-widest font-mono">EDISI KADALUWARSA</p>
                                @else
                                    <p class="text-3xl font-bold text-gold-burnished tracking-wider font-mono animate-pulse">{{ $timeLeftString }}</p>
                                @endif
                            </div>

                            <!-- Payment Method Specifics -->
                            <div class="col-span-2 space-y-3">
                                <span class="text-xs uppercase text-gray-400 tracking-widest block font-medium">Panduan Pembayaran ({{ $selectedOrder->payment_method }})</span>
                                
                                @if($selectedOrder->payment_method === 'QRIS')
                                    <div class="flex items-center gap-4 bg-moss-slate/50 p-3 rounded-lg border border-moss-emerald/20">
                                        <!-- Mock QR Box -->
                                        <div class="h-14 w-14 bg-white rounded p-1 flex items-center justify-center flex-shrink-0">
                                            <i class="fa-solid fa-qrcode text-moss-deep text-4xl"></i>
                                        </div>
                                        <p class="text-[10px] text-gray-300 leading-normal">
                                            Buka aplikasi mobile banking atau e-wallet pilihan Anda, scan QR di atas, dan selesaikan pembayaran sebelum waktu habis.
                                        </p>
                                    </div>
                                @elseif(in_array($selectedOrder->payment_method, ['Bank Transfer', 'Debit Card', 'E-Wallet']))
                                    <div class="bg-moss-slate/50 p-4 rounded-lg border border-moss-emerald/20 space-y-2 text-xs">
                                        <div class="flex justify-between items-center">
                                            <span class="text-gray-400">Nomor Virtual Account</span>
                                            <span class="font-bold text-white font-mono">9812-7012-3982-1102</span>
                                        </div>
                                        <div class="flex justify-between items-center">
                                            <span class="text-gray-400">Nama Rekening</span>
                                            <span class="text-white">LUXEBOARD SANCTUARY GLD</span>
                                        </div>
                                    </div>
                                @elseif($selectedOrder->payment_method === 'COD')
                                    <div class="bg-moss-slate/50 p-3 rounded-lg border border-moss-emerald/20 text-[10px] text-gray-300">
                                        Metode COD terdeteksi. Silakan siapkan uang tunai pas sebesar <span class="text-gold-burnished font-bold">Rp {{ number_format($selectedOrder->total_amount, 0, ',', '.') }}</span> saat kurir priority mengantarkan boks game Anda.
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Invoice Manifest Table -->
                    <div class="space-y-3">
                        <h4 class="text-xs uppercase tracking-widest text-gold-burnished font-semibold">Manifest Board Game</h4>
                        
                        <div class="bg-moss-deep border border-moss-emerald/30 rounded-xl overflow-hidden">
                            <table class="w-full text-xs font-light text-left text-gray-300 divide-y divide-moss-emerald/20">
                                <thead class="bg-moss-slate/40 text-[10px] uppercase text-gold-burnished font-medium">
                                    <tr>
                                        <th class="px-6 py-4">Item Pilihan</th>
                                        <th class="px-6 py-4 text-center">Harga Unit</th>
                                        <th class="px-6 py-4 text-center">Jumlah</th>
                                        <th class="px-6 py-4 text-right">Total</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-moss-emerald/10">
                                    @foreach($selectedOrder->items as $item)
                                        <tr>
                                            <td class="px-6 py-4 font-serif text-white font-medium">
                                                {{ $item->product ? $item->product->name : 'Masterpiece Terhapus' }}
                                            </td>
                                            <td class="px-6 py-4 text-center">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                            <td class="px-6 py-4 text-center font-bold text-white">{{ $item->quantity }}</td>
                                            <td class="px-6 py-4 text-right font-medium text-white">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Metadata details -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-xs font-light pt-4 border-t border-moss-emerald/20">
                        <div class="space-y-2">
                            <h4 class="text-xs uppercase tracking-widest text-gold-burnished font-semibold">Penerima & Alamat</h4>
                            <p class="font-semibold text-white">{{ $selectedOrder->recipient_name }}</p>
                            <p class="text-gray-400 font-mono">{{ $selectedOrder->recipient_phone }}</p>
                            <p class="text-gray-300 leading-relaxed">{{ $selectedOrder->shipping_address }}</p>
                        </div>
                        
                        <div class="space-y-4">
                            <div>
                                <h4 class="text-xs uppercase tracking-widest text-gold-burnished font-semibold">Kurir Pengiriman</h4>
                                <p class="text-white">{{ $selectedOrder->shipping_tier }} Standard &bull; Rp {{ number_format($selectedOrder->shipping_fee, 0, ',', '.') }}</p>
                            </div>
                            <div>
                                <h4 class="text-xs uppercase tracking-widest text-gold-burnished font-semibold">Metode Pembayaran</h4>
                                <p class="text-white uppercase">{{ $selectedOrder->payment_method }} &bull; {{ $selectedOrder->payment_status }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Testing Simulator & Order Management buttons -->
                    @if($selectedOrder->status === 'Created')
                        <div class="flex flex-col sm:flex-row justify-end gap-4 pt-6 border-t border-moss-emerald/20">
                            <!-- Cancel order -->
                            <button wire:click="cancelOrder" class="border border-red-500/50 text-red-400 hover:bg-red-500 hover:text-white px-6 py-3 rounded-lg text-xs uppercase tracking-wider font-semibold transition-all">
                                Batalkan Pesanan
                            </button>
                            <!-- Simulate verification -->
                            <button wire:click="simulatePayment" class="bg-gold-burnished hover:bg-gold-dark text-moss-deep px-6 py-3 rounded-lg text-xs uppercase tracking-wider font-bold transition-all shadow-md">
                                <i class="fa-solid fa-microchip mr-2"></i> Konfirmasi Pembayaran (Simulator)
                            </button>
                        </div>
                    @endif

                </div>
            @endif
        </div>

    </div>
</div>
