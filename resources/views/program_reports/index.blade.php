@extends('layouts.app')

@section('title', 'Senarai Laporan Program - SKPKKKL')

@section('content')
<div class="max-w-7xl mx-auto">
    
    @if(session('success'))
    <div class="mb-6 bg-emerald-50 border border-emerald-100 text-emerald-600 px-4 py-3 rounded-xl text-sm flex items-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        {{ session('success') }}
    </div>
    @endif

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden min-w-0">
            <!-- Table for Desktop -->
            <div class="overflow-x-auto hidden md:block">
                <table class="w-full text-left border-collapse min-w-[800px]">
                    <thead>
                        <tr class="text-gray-400 text-xs uppercase tracking-wider border-b border-gray-100 font-bold bg-gray-50/10">
                            <th class="px-6 py-4 font-medium">Nama Program</th>
                            <th class="px-6 py-4 font-medium">Tarikh</th>
                            <th class="px-6 py-4 font-medium">Lokasi</th>
                            <th class="px-6 py-4 font-medium">Jenis</th>
                            <th class="px-6 py-4 font-medium">Bajet (RM)</th>
                            <th class="px-6 py-4 font-medium">PIC</th>
                            <th class="px-6 py-4 font-medium">Butiran</th>
                            <th class="px-6 py-4 font-medium text-right">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-sm">
                        @forelse($reports as $report)
                        <tr class="hover:bg-gray-50/80 transition-colors group">
                            <td class="px-6 py-4 font-bold text-gray-800">
                                {{ $report->name_of_program }}
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ $report->date->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ $report->location }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $report->type === 'sukan' ? 'bg-blue-50 text-blue-600 border border-blue-100' : 'bg-purple-50 text-purple-600 border border-purple-100' }}">
                                    {{ $report->type }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-600 font-bold">
                                {{ number_format($report->budget, 2) }}
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ $report->pic_user_id ? $report->pic->name : '-' }}
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ $report->payment_details ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <a href="{{ route('program-reports.show', $report->id) }}" class="text-blue-600 hover:bg-blue-50 px-3 py-1.5 rounded-lg font-bold transition-colors text-xs uppercase tracking-wider">
                                    Butiran
                                </a>
                                @if(Auth::user()->isAdmin() || Auth::id() === $report->user_id)
                                    <form action="{{ route('program-reports.destroy', $report->id) }}" method="POST" class="inline" onsubmit="return confirm('Adakah anda pasti mahu memadam laporan ini? Permohonan dana berkaitan juga akan dipadam.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:bg-red-50 px-3 py-1.5 rounded-lg font-bold transition-colors text-xs uppercase tracking-wider">
                                            Padam
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-gray-500">Tiada laporan program ditemui.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Cards for Mobile -->
            <div class="md:hidden divide-y divide-gray-100">
                @forelse($reports as $report)
                <div class="p-5 space-y-4">
                    <div class="flex justify-between items-start gap-4">
                        <div class="min-w-0 flex-1">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="px-2 py-0.5 rounded-full text-[9px] font-bold uppercase tracking-wider {{ $report->type === 'sukan' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700' }}">
                                    {{ $report->type }}
                                </span>
                                <span class="text-[10px] text-gray-400 font-medium tracking-tight">{{ $report->date->format('d/m/Y') }}</span>
                            </div>
                            <p class="font-bold text-gray-900 leading-snug mb-1">{{ $report->name_of_program }}</p>
                            <p class="text-xs text-gray-500 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                {{ $report->location }}
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="text-[10px] text-gray-400 uppercase font-bold tracking-widest mb-0.5">Bajet</p>
                            <p class="font-bold text-blue-600 text-sm">RM {{ number_format($report->budget, 2) }}</p>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50/50 rounded-xl p-3 flex justify-between items-center border border-gray-100">
                        <div class="min-w-0">
                            <p class="text-[9px] text-gray-400 uppercase font-bold tracking-widest mb-0.5">PIC Program</p>
                            <p class="text-xs font-semibold text-gray-700 truncate">{{ $report->pic_user_id ? $report->pic->name : '-' }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-[9px] text-gray-400 uppercase font-bold tracking-widest mb-0.5">Butiran Bayaran</p>
                            <p class="text-xs font-semibold text-gray-700 truncate max-w-[120px]">{{ $report->payment_details ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="flex gap-2">
                        <a href="{{ route('program-reports.show', $report->id) }}" class="flex-1 text-center bg-white border border-gray-200 text-gray-700 py-3 rounded-xl font-bold text-[10px] uppercase tracking-widest shadow-sm active:scale-95 transition-all">
                            Butiran
                        </a>
                        @if(Auth::user()->isAdmin() || Auth::id() === $report->user_id)
                            <form action="{{ route('program-reports.destroy', $report->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Padam laporan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full bg-red-50 text-red-600 py-3 rounded-xl font-bold text-[10px] uppercase tracking-widest border border-red-100 shadow-sm active:scale-95 transition-all">
                                    Padam
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
                @empty
                <div class="p-12 text-center text-gray-500 text-sm">
                    Tiada laporan program ditemui.
                </div>
                @endforelse
            </div>
        </div>

</div>

<!-- Floating Print All Button -->
<div class="fixed bottom-8 right-8 z-30">
    <a href="{{ route('program-reports.print-all') }}" target="_blank" class="flex items-center gap-1.5 px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl shadow-lg shadow-blue-600/20 transition-all font-bold text-xs uppercase tracking-wider">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
        Cetak
    </a>
</div>
@endsection
