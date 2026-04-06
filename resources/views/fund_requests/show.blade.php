<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Butiran Permohonan - SKPKKKL</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased" x-data="{ showModal: false, modalUrl: '', modalTitle: '', isRequired: false, action: '', modalColor: 'blue' }">
    <div class="flex h-screen overflow-hidden">
        
        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto w-full">
            @include('partials.header', ['title' => 'Butiran Permohonan Dana'])

            <div class="p-6 sm:p-8 max-w-5xl mx-auto">
                
                @if(session('success'))
                <div class="mb-6 bg-emerald-50 border border-emerald-100 text-emerald-600 px-4 py-3 rounded-xl text-sm flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    {{ session('success') }}
                </div>
                @endif

                @if(session('error'))
                <div class="mb-6 bg-red-50 border border-red-100 text-red-600 px-4 py-3 rounded-xl text-sm flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ session('error') }}
                </div>
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <!-- Left: Details -->
                    <div class="lg:col-span-2 space-y-6">
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
                            <div class="flex justify-between items-start mb-6">
                                <div>
                                    <h2 class="text-2xl font-bold text-gray-900">{{ $fundRequest->programReport->name_of_program }}</h2>
                                    <p class="text-gray-500">Dikemukakan oleh {{ $fundRequest->requester->name }} pada {{ $fundRequest->created_at->format('d M Y, h:i A') }}</p>
                                </div>
                                <div class="px-4 py-1.5 rounded-full text-xs font-semibold uppercase tracking-wider
                                    @if($fundRequest->status == 'approved_by_boss') bg-emerald-50 text-emerald-600 border border-emerald-100
                                    @elseif($fundRequest->status == 'rejected') bg-red-50 text-red-600 border border-red-100
                                    @else bg-amber-50 text-amber-600 border border-amber-100 @endif">
                                    {{ str_replace('_', ' ', $fundRequest->status) }}
                                </div>
                            </div>

                            @if($fundRequest->status === 'rejected' && $fundRequest->rejection_reason)
                            <div class="mb-8 p-5 bg-red-50/50 border border-red-100 rounded-2xl">
                                <p class="text-xs font-bold text-red-600 uppercase tracking-widest mb-1">Sebab Penolakan</p>
                                <p class="text-gray-700 italic">"{{ $fundRequest->rejection_reason }}"</p>
                            @elseif($fundRequest->status === 'approved_by_boss' && $fundRequest->approval_reason)
                            <div class="mb-8 p-5 bg-emerald-50/50 border border-emerald-100 rounded-2xl">
                                <p class="text-xs font-bold text-emerald-600 uppercase tracking-widest mb-1">Nota Kelulusan</p>
                                <p class="text-gray-700 italic">"{{ $fundRequest->approval_reason }}"</p>
                            </div>
                            @endif

                            <div class="grid grid-cols-2 gap-8 py-6 border-y border-gray-50">
                                <div>
                                    <p class="text-xs text-gray-400 uppercase font-semibold mb-1">Tarikh Program</p>
                                    <p class="text-gray-800 font-medium">{{ $fundRequest->programReport->date->format('d M Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400 uppercase font-semibold mb-1">Lokasi</p>
                                    <p class="text-gray-800 font-medium">{{ $fundRequest->programReport->location }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400 uppercase font-semibold mb-1">Bajet Dipohon</p>
                                    <p class="text-lg font-bold text-blue-600">RM {{ number_format($fundRequest->programReport->budget, 2) }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400 uppercase font-semibold mb-1">Penganjur</p>
                                    <p class="text-gray-800 font-medium">{{ $fundRequest->programReport->organizer }}</p>
                                </div>
                            </div>

                            <div class="mt-6">
                                <p class="text-xs text-gray-400 uppercase font-semibold mb-2">Bukti Gambar / Dokumen</p>
                                @if($fundRequest->programReport->image_proof_path)
                                <div class="rounded-xl overflow-hidden border border-gray-200 bg-gray-50">
                                    <img src="{{ asset('storage/' . $fundRequest->programReport->image_proof_path) }}" alt="Bukti" class="w-full h-auto">
                                </div>
                                @else
                                <p class="text-sm text-gray-500 italic">Tiada fail dimuat naik.</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Right: Actions & Approvals -->
                    <div class="space-y-6">
                        
                        <!-- Approval Card -->
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                            <h3 class="font-bold text-gray-900 mb-4">Status Kelulusan</h3>
                            
                            <div class="space-y-4 mb-6">
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="text-gray-500">Sokongan Ahli Jawatankuasa</span>
                                    <span class="font-bold text-blue-600">{{ $fundRequest->total_member_approvals }}/18</span>
                                </div>
                                <div class="w-full bg-gray-100 rounded-full h-2">
                                    <div class="bg-blue-600 h-2 rounded-full transition-all duration-500" style="width: {{ min(100, ($fundRequest->total_member_approvals / 18) * 100) }}%"></div>
                                </div>
                            </div>

                            @if($fundRequest->status !== 'approved_by_boss' && $fundRequest->status !== 'rejected')
                                @if(Auth::user()->role === 'boss')
                                    @if($fundRequest->status === 'pending_boss')
                                        <div class="flex flex-col gap-3">
                                            <button @click="showModal = true; modalUrl = '{{ route('fund-requests.boss-action', $fundRequest->id) }}'; modalTitle = 'Luluskan Permohonan (Pengerusi)'; isRequired = false; action = 'approve'; modalColor = 'emerald'"
                                                class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 rounded-xl transition-colors shadow-sm shadow-emerald-600/20">
                                                Luluskan Permohonan
                                            </button>
                                            <button @click="showModal = true; modalUrl = '{{ route('fund-requests.boss-action', $fundRequest->id) }}'; modalTitle = 'Tolak Permohonan (Pengerusi)'; isRequired = true; action = 'reject'; modalColor = 'red'" 
                                                class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 rounded-xl transition-colors shadow-sm shadow-red-600/20">
                                                Tolak Permohonan
                                            </button>
                                        </div>
                                    @else
                                        <p class="text-sm text-center text-gray-500 py-4 bg-gray-50 rounded-xl italic">Menunggu sokongan 18 ahli Jawatankuasa sebelum tindakan Pengerusi.</p>
                                    @endif
                                @else
                                    @if($fundRequest->requester_id !== Auth::id())
                                        @if(!$fundRequest->approvals()->where('member_id', Auth::id())->exists())
                                    <div class="flex flex-col gap-3">
                                        <!-- SETUJU (HIJAU) -->
                                        <button 
                                            @click="showModal = true; modalUrl = '{{ route('fund-requests.approve', $fundRequest->id) }}'; modalTitle = 'Setuju'; isRequired = false; action = 'approve'; modalColor = 'green'"
                                            class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 rounded-xl transition-colors shadow-sm shadow-green-600/20">
                                            Setuju
                                        </button>

                                        <!-- TIDAK SETUJU (MERAH) -->
                                        <button 
                                            @click="showModal = true; modalUrl = '{{ route('fund-requests.reject', $fundRequest->id) }}'; modalTitle = 'Tidak Setuju'; isRequired = true; action = 'reject'; modalColor = 'red'" 
                                            class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 rounded-xl transition-colors shadow-sm shadow-red-600/20">
                                            Tidak Setuju
                                        </button>
                                    </div>
                                        @else
                                        <p class="text-sm text-center text-emerald-600 py-4 bg-emerald-50 rounded-xl font-medium">Anda telah memberikan maklum balas.</p>
                                        @endif
                                    @else
                                        <p class="text-sm text-center text-gray-500 py-4 bg-blue-50 text-blue-600 rounded-xl font-medium italic">Ini adalah permohonan anda sendiri.</p>
                                    @endif
                                @endif
                            @else
                                <div class="py-4 px-4 bg-gray-50 rounded-2xl border border-gray-100 text-center">
                                    <p class="text-sm font-bold text-gray-500 uppercase tracking-widest">Status Akhir</p>
                                    <p class="text-lg font-bold {{ $fundRequest->status === 'approved_by_boss' ? 'text-emerald-600' : 'text-red-600' }}">
                                        {{ $fundRequest->status === 'approved_by_boss' ? 'DILULUSKAN' : 'DITOLAK' }}
                                    </p>
                                </div>
                            @endif
                        </div>

                        <!-- Logs -->
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 text-sm">
                            <h3 class="font-bold text-gray-900 mb-4">Log Sokongan Ahli</h3>
                            <div class="space-y-4 max-h-80 overflow-y-auto pr-2">
                                @forelse($fundRequest->approvals as $approval)
                                <div class="flex items-start gap-3">
                                    <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center shrink-0 border border-gray-200">
                                        <span class="text-xs font-bold text-gray-500">{{ strtoupper(substr($approval->member->name,0,1)) }}</span>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-semibold text-gray-800">{{ $approval->member->name }}</p>
                                        <p class="text-xs {{ $approval->status === 'approved' ? 'text-emerald-500' : 'text-red-500' }}">
                                            {{ $approval->status === 'approved' ? 'Telah menyokong' : 'Telah menolak' }}
                                        </p>
                                        @if($approval->reason)
                                            <p class="text-[11px] text-gray-500 mt-1 italic font-medium bg-gray-50 p-2 rounded-lg border border-gray-100">"{{ $approval->reason }}"</p>
                                        @endif
                                    </div>
                                    <span class="text-[10px] text-gray-400 shrink-0">{{ $approval->created_at->diffForHumans() }}</span>
                                </div>
                                @empty
                                <p class="text-xs text-gray-400 text-center py-4 italic">Belum ada sokongan setakat ini.</p>
                                @endforelse
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Unified Modal (Approve/Reject) -->
    <div x-show="showModal" 
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        style="display: none;">
        
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md overflow-hidden" 
            @click.away="showModal = false"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100">
            
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-900" x-text="modalTitle">Tindakan</h3>
                    <button @click="showModal = false" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                
                <form :action="modalUrl" method="POST" id="actionForm">
                    @csrf
                    <input type="hidden" name="action" :value="action">
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Sebab / Nota <span x-show="isRequired" class="text-red-500">*wajib</span>
                        </label>
                        <textarea name="reason" rows="4" :required="isRequired" 
                            :placeholder="isRequired ? 'Sila nyatakan sebab kenapa permohonan ini ditolak...' : 'Masukkan nota tambahan jika ada (pilihan)...'" 
                            class="block w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm bg-gray-50/50 resize-none"
                            :class="modalColor === 'red' ? 'focus:border-red-500 focus:ring-red-500' : (modalColor === 'emerald' ? 'focus:border-emerald-500 focus:ring-emerald-500' : 'focus:border-blue-500 focus:ring-blue-500')"></textarea>
                    </div>
                    
                    <div class="flex gap-3">
                        <button type="button" @click="showModal = false" class="flex-1 px-6 py-3 rounded-xl text-sm font-medium text-gray-500 hover:bg-gray-100 transition-colors">Batal</button>
                        <button type="submit" 
                            class="flex-1 px-6 py-3 rounded-xl text-sm font-medium text-white transition-colors shadow-sm"
                            :class="modalColor === 'red' ? 'bg-red-600 hover:bg-red-700 shadow-red-600/20' : (modalColor === 'emerald' ? 'bg-emerald-600 hover:bg-emerald-700 shadow-emerald-600/20' : 'bg-blue-600 hover:bg-blue-700 shadow-blue-600/20')">
                            Hantar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
