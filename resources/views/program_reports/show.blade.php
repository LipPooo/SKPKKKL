@extends('layouts.app')

@section('title', 'Butiran Laporan Program - SKPKKKL')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sm:p-8">
        <div class="flex flex-col sm:flex-row justify-between items-start mb-8 gap-6">
            <div>
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-1 leading-tight">{{ $report->name_of_program }}</h2>
                <p class="text-gray-500 text-sm">Disediakan oleh {{ $report->user->name }} pada {{ $report->created_at->format('d M Y') }}</p>
            </div>
            <div class="flex flex-wrap items-center gap-3 shrink-0">
                <a href="{{ route('program-reports.print', $report->id) }}" target="_blank" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl text-[10px] font-bold uppercase tracking-wider text-gray-600 bg-gray-100 hover:bg-gray-200 transition-all border border-gray-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Cetak
                </a>
                @if(Auth::user()->isAdmin() || Auth::id() === $report->user_id)
                    <form action="{{ route('program-reports.destroy', $report->id) }}" method="POST" class="inline" onsubmit="return confirm('Adakah anda pasti mahu memadam laporan ini? Permohonan dana berkaitan juga akan dipadam.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl text-[10px] font-bold uppercase tracking-wider text-red-600 bg-red-50 hover:bg-red-100 transition-all border border-red-100">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            Padam
                        </button>
                    </form>
                @endif
                <span class="px-3 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-rose-50 text-rose-600 border border-rose-100">
                    {{ $report->type }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8 py-8 border-y border-gray-50">
            <div class="space-y-6">
                <div>
                    <p class="text-[10px] text-gray-400 uppercase font-bold tracking-widest mb-1">Tarikh Program</p>
                    <p class="text-gray-900 font-semibold">{{ $report->date->format('d F Y') }}</p>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 uppercase font-bold tracking-widest mb-1">Lokasi</p>
                    <p class="text-gray-900 font-semibold">{{ $report->location }}</p>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 uppercase font-bold tracking-widest mb-1">Penganjur</p>
                    <p class="text-gray-900 font-semibold">{{ $report->organizer }}</p>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 uppercase font-bold tracking-widest mb-1">Penyertaan (Ahli / Bukan Ahli)</p>
                    <p class="text-gray-900 font-semibold">{{ $report->total_members_involved }} / {{ $report->total_non_members ?? 0 }} <span class="text-gray-400 text-xs">(Jumlah: {{ $report->total_participation }})</span></p>
                </div>
            </div>
            <div class="space-y-6">
                <div>
                    <p class="text-[10px] text-gray-400 uppercase font-bold tracking-widest mb-1">Bajet Keseluruhan</p>
                    <p class="text-2xl font-bold text-rose-600">RM {{ number_format($report->budget, 2) }}</p>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 uppercase font-bold tracking-widest mb-1">Butiran (Charge Code/nPOS/Resit)</p>
                    <p class="text-gray-900 font-semibold">{{ $report->payment_details ?? 'Tiada' }}</p>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 uppercase font-bold tracking-widest mb-1">Person In Charge (PIC)</p>
                    <p class="text-gray-900 font-semibold">
                        @if($report->pic_user_id)
                            {{ $report->pic->name }} <span class="text-xs text-gray-400 font-normal">({{ $report->pic->employee_id ?? 'Tiada ID' }})</span>
                        @else
                            <span class="text-gray-400 italic font-normal">Tiada PIC Ditetapkan</span>
                        @endif
                    </p>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 uppercase font-bold tracking-widest mb-1">Kolaborasi</p>
                    <p class="text-gray-900 font-semibold">{{ $report->collaboration ?? 'Tiada' }}</p>
                </div>
            </div>
        </div>

        <div class="mt-8 space-y-8">
            @if($report->vip_details)
            <div>
                <p class="text-[10px] text-gray-400 uppercase font-bold tracking-widest mb-2">Butiran VIP</p>
                <p class="text-gray-700 leading-relaxed bg-gray-50 p-4 rounded-xl border border-gray-100 italic">"{{ $report->vip_details }}"</p>
            </div>
            @endif

            @if($report->recognition)
            <div>
                <p class="text-[10px] text-gray-400 uppercase font-bold tracking-widest mb-2">Pengiktirafan</p>
                <p class="text-gray-800 leading-relaxed bg-gray-50/50 p-4 rounded-xl">{{ $report->recognition }}</p>
            </div>
            @endif

            <div>
                <p class="text-[10px] text-gray-400 uppercase font-bold tracking-widest mb-3">Bukti Gambar / Lampiran</p>
                @if($report->image_proof_path)
                <div class="rounded-2xl overflow-hidden border border-gray-100 shadow-sm bg-gray-50">
                    <img src="{{ asset('storage/' . $report->image_proof_path) }}" alt="Bukti Gambar" class="w-full h-auto object-cover">
                </div>
                @else
                <div class="bg-gray-50 rounded-2xl p-12 border border-dashed border-gray-200 text-center">
                    <p class="text-gray-400 italic text-sm">Tiada fail bukti dimuat naik.</p>
                </div>
                @endif
            </div>
        </div>

        <div class="mt-12 flex flex-col sm:flex-row justify-between items-center bg-gray-50/50 p-6 rounded-2xl border border-gray-100 gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-rose-100 flex items-center justify-center text-rose-600 shadow-sm border border-rose-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-800">Status Permohonan Dana</p>
                    <p class="text-[10px] text-gray-500 font-medium uppercase tracking-wider">Permohonan dana dijana sistem</p>
                </div>
            </div>
            @if($report->fundRequest)
            <a href="{{ route('fund-requests.show', $report->fundRequest->id) }}" class="w-full sm:w-auto text-center px-5 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider text-white bg-rose-600 hover:bg-rose-700 transition-all shadow-lg shadow-rose-600/20">
                Semak Status
            </a>
            @else
            <p class="text-[10px] text-red-500 font-bold uppercase tracking-widest bg-red-50 px-3 py-1.5 rounded-lg border border-red-100">Tiada Dana</p>
            @endif
        </div>
    </div>
</div>
@endsection

