@extends('layouts.app')

@section('title', 'Butiran Permohonan - SKPKKKL')

@section('content')
<div class="max-w-5xl mx-auto" x-data="{ showModal: false, modalUrl: '', modalTitle: '', isRequired: false, action: '', modalColor: 'blue' }">
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left: Details -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sm:p-8">
                <div class="flex flex-col sm:flex-row justify-between items-start mb-6 gap-4">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">{{ $fundRequest->programReport->name_of_program }}</h2>
                        <p class="text-gray-500 text-sm">Dikemukakan oleh {{ $fundRequest->requester->name }} pada {{ $fundRequest->created_at->format('d M Y, h:i A') }}</p>
                    </div>
                    <div class="shrink-0 px-4 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-wider border
                        @if($fundRequest->status == 'approved_by_boss') bg-emerald-50 text-emerald-600 border-emerald-100
                        @elseif($fundRequest->status == 'rejected') bg-red-50 text-red-600 border-red-100
                        @else bg-amber-50 text-amber-600 border-amber-100 @endif">
                        {{ str_replace('_', ' ', $fundRequest->status) }}
                    </div>
                </div>

                @if($fundRequest->status === 'rejected' && $fundRequest->rejection_reason)
                <div class="mb-8 p-5 bg-red-50/50 border border-red-100 rounded-2xl">
                    <p class="text-xs font-bold text-red-600 uppercase tracking-widest mb-1">Sebab Penolakan</p>
                    <p class="text-gray-700 italic">"{{ $fundRequest->rejection_reason }}"</p>
                </div>
                @elseif($fundRequest->status === 'approved_by_boss' && $fundRequest->approval_reason)
                <div class="mb-8 p-5 bg-emerald-50/50 border border-emerald-100 rounded-2xl">
                    <p class="text-xs font-bold text-emerald-600 uppercase tracking-widest mb-1">Nota Kelulusan</p>
                    <p class="text-gray-700 italic">"{{ $fundRequest->approval_reason }}"</p>
                </div>
                @endif

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 py-6 border-y border-gray-50">
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-bold mb-1">Tarikh Program</p>
                        <p class="text-gray-800 font-medium">{{ $fundRequest->programReport->date->format('d M Y') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-bold mb-1">Lokasi</p>
                        <p class="text-gray-800 font-medium">{{ $fundRequest->programReport->location }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-bold mb-1">Bajet Dipohon</p>
                        <p class="text-lg font-bold text-blue-600">RM {{ number_format($fundRequest->programReport->budget, 2) }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-bold mb-1">Penganjur</p>
                        <p class="text-gray-800 font-medium">{{ $fundRequest->programReport->organizer }}</p>
                    </div>
                </div>

                <div class="mt-8">
                    <p class="text-xs text-gray-400 uppercase font-bold mb-3">Bukti Gambar / Dokumen</p>
                    @if($fundRequest->programReport->image_proof_path)
                    <div class="rounded-2xl overflow-hidden border border-gray-100 bg-gray-50">
                        <img src="{{ asset('storage/' . $fundRequest->programReport->image_proof_path) }}" alt="Bukti" class="w-full h-auto">
                    </div>
                    @else
                    <p class="text-sm text-gray-500 italic px-4 py-8 bg-gray-50 rounded-2xl text-center border border-dashed border-gray-200">Tiada fail dimuat naik.</p>
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
                                    Luluskan
                                </button>
                                <button @click="showModal = true; modalUrl = '{{ route('fund-requests.boss-action', $fundRequest->id) }}'; modalTitle = 'Tolak Permohonan (Pengerusi)'; isRequired = true; action = 'reject'; modalColor = 'red'" 
                                    class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 rounded-xl transition-colors shadow-sm shadow-red-600/20">
                                    Tolak
                                </button>
                            </div>
                        @else
                            <p class="text-xs text-center text-gray-500 py-4 bg-gray-50 rounded-xl italic px-3">Menunggu sokongan 18 ahli Jawatankuasa sebelum tindakan Pengerusi.</p>
                        @endif
                    @else
                        @if($fundRequest->requester_id !== Auth::id())
                            @if(!$fundRequest->approvals()->where('member_id', Auth::id())->exists())
                        <div class="flex flex-col gap-3">
                            <button 
                                @click="showModal = true; modalUrl = '{{ route('fund-requests.approve', $fundRequest->id) }}'; modalTitle = 'Setuju'; isRequired = false; action = 'approve'; modalColor = 'green'"
                                class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 rounded-xl transition-colors shadow-sm shadow-green-600/20">
                                Setuju
                            </button>
                            <button 
                                @click="showModal = true; modalUrl = '{{ route('fund-requests.reject', $fundRequest->id) }}'; modalTitle = 'Tidak Setuju'; isRequired = true; action = 'reject'; modalColor = 'red'" 
                                class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 rounded-xl transition-colors shadow-sm shadow-red-600/20">
                                Tidak Setuju
                            </button>
                        </div>
                            @else
                            <p class="text-sm text-center text-emerald-600 py-4 bg-emerald-50 rounded-xl font-bold">Anda telah maklum balas.</p>
                            @endif
                        @else
                            <p class="text-sm text-center text-blue-600 py-4 bg-blue-50 rounded-xl font-bold italic">Permohonan anda sendiri.</p>
                        @endif
                    @endif
                @else
                    <div class="py-4 px-4 bg-gray-50 rounded-2xl border border-gray-100 text-center">
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-1">Status Akhir</p>
                        <p class="text-lg font-bold {{ $fundRequest->status === 'approved_by_boss' ? 'text-emerald-600' : 'text-red-600' }}">
                            {{ $fundRequest->status === 'approved_by_boss' ? 'DILULUSKAN' : 'DITOLAK' }}
                        </p>
                    </div>
                @endif
            </div>

            <!-- Logs -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 text-sm">
                <h3 class="font-bold text-gray-900 mb-4">Log Sokongan Ahli</h3>
                <div class="space-y-4 max-h-80 overflow-y-auto pr-2 custom-scrollbar">
                    @forelse($fundRequest->approvals as $approval)
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center shrink-0 border border-gray-200">
                            <span class="text-xs font-bold text-gray-500">{{ strtoupper(substr($approval->member->name,0,1)) }}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-bold text-gray-800 truncate">{{ $approval->member->name }}</p>
                            <p class="text-[11px] {{ $approval->status === 'approved' ? 'text-emerald-500' : 'text-red-500' }} font-bold">
                                {{ $approval->status === 'approved' ? 'Telah menyokong' : 'Telah menolak' }}
                            </p>
                            @if($approval->reason)
                                <p class="text-[11px] text-gray-500 mt-1 italic font-medium bg-gray-50 p-2 rounded-xl border border-gray-100">"{{ $approval->reason }}"</p>
                            @endif
                        </div>
                    </div>
                    @empty
                    <p class="text-xs text-gray-400 text-center py-4 italic">Belum ada sokongan.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>

    <!-- Unified Modal (Approve/Reject) -->
    <div x-show="showModal" 
        class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm"
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
                        <label class="block text-sm font-bold text-gray-700 mb-2">
                            Sebab / Nota <span x-show="isRequired" class="text-red-500">*wajib</span>
                        </label>
                        <textarea name="reason" rows="4" :required="isRequired" 
                            :placeholder="isRequired ? 'Sila nyatakan sebab...' : 'Masukkan nota tambahan (pilihan)...'" 
                            class="block w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm bg-gray-50/50 resize-none"
                            :class="modalColor === 'red' ? 'focus:border-red-500 focus:ring-red-500' : (modalColor === 'emerald' ? 'focus:border-emerald-500 focus:ring-emerald-500' : 'focus:border-blue-500 focus:ring-blue-500')"></textarea>
                    </div>
                    
                    <div class="flex gap-3">
                        <button type="button" @click="showModal = false" class="flex-1 px-6 py-3 rounded-xl text-sm font-medium text-gray-500 hover:bg-gray-100 transition-colors">Batal</button>
                        <button type="submit" 
                            class="flex-1 px-6 py-3 rounded-xl text-sm font-bold text-white transition-colors shadow-sm"
                            :class="modalColor === 'red' ? 'bg-red-600 hover:bg-red-700 shadow-red-600/20' : (modalColor === 'emerald' ? 'bg-emerald-600 hover:bg-emerald-700 shadow-emerald-600/20' : 'bg-blue-600 hover:bg-blue-700 shadow-blue-600/20')">
                            Hantar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

