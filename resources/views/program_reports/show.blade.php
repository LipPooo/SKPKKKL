<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Butiran Laporan Program - SKPKKKL</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased">
    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar -->
        @include('partials.sidebar')
        <main class="flex-1 overflow-y-auto w-full">
    @include('partials.header', ['title' => 'Butiran Laporan Program'])

            <div class="p-6 sm:p-8 max-w-4xl mx-auto">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
                    <div class="flex justify-between items-start mb-8">
                        <div>
                            <h2 class="text-3xl font-bold text-gray-900 mb-1">{{ $report->name_of_program }}</h2>
                            <p class="text-gray-500">Disediakan oleh {{ $report->user->name }} pada {{ $report->created_at->format('d M Y') }}</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <a href="{{ route('program-reports.print', $report->id) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-1.5 rounded-xl text-xs font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200 transition-all border border-gray-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                Cetak Laporan
                            </a>
                            <span class="px-4 py-1.5 rounded-full text-xs font-semibold uppercase tracking-wider bg-blue-50 text-blue-600 border border-blue-100">
                                {{ $report->type }}
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8 py-8 border-y border-gray-50">
                        <div class="space-y-6">
                            <div>
                                <p class="text-[10px] text-gray-400 uppercase font-bold tracking-widest mb-1">Tarikh Program</p>
                                <p class="text-gray-900 font-medium">{{ $report->date->format('d F Y') }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] text-gray-400 uppercase font-bold tracking-widest mb-1">Lokasi</p>
                                <p class="text-gray-900 font-medium">{{ $report->location }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] text-gray-400 uppercase font-bold tracking-widest mb-1">Penganjur</p>
                                <p class="text-gray-900 font-medium">{{ $report->organizer }}</p>
                            </div>
                        </div>
                        <div class="space-y-6">
                            <div>
                                <p class="text-[10px] text-gray-400 uppercase font-bold tracking-widest mb-1">Bajet Keseluruhan</p>
                                <p class="text-2xl font-bold text-blue-600">RM {{ number_format($report->budget, 2) }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] text-gray-400 uppercase font-bold tracking-widest mb-1">Butiran (Charge Code/nPOS/Resit)</p>
                                <p class="text-gray-900 font-medium">{{ $report->payment_details ?? 'Tiada' }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] text-gray-400 uppercase font-bold tracking-widest mb-1">Person In Charge (PIC)</p>
                                <p class="text-gray-900 font-medium">
                                    @if($report->pic_user_id)
                                        {{ $report->pic->name }} (No Pekerja: {{ $report->pic->employee_id ?? 'Tiada' }})
                                    @else
                                        <span class="text-gray-400 italic">Tiada PIC Ditetapkan</span>
                                    @endif
                                </p>
                            </div>
                            <div>
                                <p class="text-[10px] text-gray-400 uppercase font-bold tracking-widest mb-1">Penyertaan (Ahli / Bukan Ahli)</p>
                                <p class="text-gray-900 font-medium">{{ $report->total_members_involved }} / {{ $report->total_non_members ?? 0 }} (Jumlah: {{ $report->total_participation }})</p>
                            </div>
                            <div>
                                <p class="text-[10px] text-gray-400 uppercase font-bold tracking-widest mb-1">Kolaborasi</p>
                                <p class="text-gray-900 font-medium">{{ $report->collaboration ?? 'Tiada' }}</p>
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
                            <p class="text-gray-700 leading-relaxed">{{ $report->recognition }}</p>
                        </div>
                        @endif

                        <div>
                            <p class="text-[10px] text-gray-400 uppercase font-bold tracking-widest mb-3">Bukti Gambar / Lampiran</p>
                            @if($report->image_proof_path)
                            <div class="rounded-2xl overflow-hidden border border-gray-100 shadow-sm bg-gray-50 group transition-all">
                                <img src="{{ asset('storage/' . $report->image_proof_path) }}" alt="Bukti Gambar" class="w-full h-auto object-cover">
                            </div>
                            @else
                            <div class="bg-gray-50 rounded-xl p-8 border border-gray-100 text-center">
                                <p class="text-gray-400 italic text-sm">Tiada fail bukti dimuat naik.</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="mt-12 flex justify-between items-center bg-gray-50/50 p-6 rounded-2xl border border-gray-100">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-800">Status Permohonan Dana</p>
                                <p class="text-xs text-gray-500">Permohonan dana dijana secara automatik</p>
                            </div>
                        </div>
                        @if($report->fundRequest)
                        <a href="{{ route('fund-requests.show', $report->fundRequest->id) }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 transition-all shadow-sm shadow-blue-600/20">
                            Semak Status Dana
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7m0 0l-7 7m7-7H6"></path></svg>
                        </a>
                        @else
                        <p class="text-xs text-red-500 font-medium bg-red-50 px-3 py-1.5 rounded-lg border border-red-100">Tiada permohonan dana ditemui</p>
                        @endif
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
