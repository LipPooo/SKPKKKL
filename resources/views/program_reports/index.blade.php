<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Senarai Laporan Program - SKPKKKL</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased">
    <div class="flex h-screen overflow-hidden">
        
        @include('partials.sidebar')

        <!-- Main Content -->
        <main class="flex-1 flex flex-col relative overflow-hidden">
            @include('partials.header', ['title' => 'Senarai Laporan Program'])

            <div class="flex-1 overflow-y-auto w-full p-6 sm:p-8">
                <div class="max-w-7xl mx-auto">
                    
                    @if(session('success'))
                    <div class="mb-6 bg-emerald-50 border border-emerald-100 text-emerald-600 px-4 py-3 rounded-xl text-sm flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        {{ session('success') }}
                    </div>
                    @endif

                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="text-gray-400 text-xs uppercase tracking-wider border-b border-gray-100">
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
                                    <td class="px-6 py-4 font-semibold text-gray-800">
                                        {{ $report->name_of_program }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-600">
                                        {{ $report->date->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-600">
                                        {{ $report->location }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $report->type === 'sukan' ? 'bg-blue-50 text-blue-600' : 'bg-purple-50 text-purple-600' }}">
                                            {{ ucfirst($report->type) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-gray-600">
                                        {{ number_format($report->budget, 2) }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-600">
                                        {{ $report->pic_user_id ? $report->pic->name : '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-600">
                                        {{ $report->payment_details ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('program-reports.show', $report->id) }}" class="text-blue-600 hover:bg-blue-50 px-3 py-1.5 rounded-lg font-medium transition-colors">
                                            Butiran
                                        </a>
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

            </div>

            <!-- Floating Print All Button -->
            <div class="fixed bottom-8 right-8 z-50">
                <a href="{{ route('program-reports.print-all') }}" target="_blank" class="flex items-center gap-1.5 px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl shadow-lg shadow-blue-600/20 transition-all font-bold text-xs uppercase tracking-wider">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Cetak
                </a>
            </div>
        </main>
    </div>
</body>
</html>
