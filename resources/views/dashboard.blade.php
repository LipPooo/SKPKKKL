<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard SKPKKKL</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased">
    <!-- Layout Wrapper -->
    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar -->
        @include('partials.sidebar')

        <!-- Main Content -->
        <main class="flex-1 flex flex-col relative overflow-hidden">
            
            <!-- Top Header -->
            @include('partials.header', ['title' => 'Ringkasan Utama', 'user' => $user])

            <!-- Scrollable Content -->
            <div class="flex-1 overflow-y-auto w-full">
                <div class="p-6 sm:p-8 max-w-7xl mx-auto space-y-8">
                    
                    <!-- Welcome Section -->
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">Selamat Kembali, {{ $user->name }} 👋</h2>
                            <p class="text-gray-500 mt-1 text-sm">
                                @if($user->role === 'boss')
                                    Berikut adalah status permohonan terkini untuk kelulusan anda.
                                @else
                                    Sila pantau status permohonan anda dan berikan sokongan yang diperlukan.
                                @endif
                            </p>
                        </div>
                        <a href="{{ route('program-reports.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl text-sm font-medium transition-colors shadow-sm shadow-blue-600/20 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Permohonan Baru
                        </a>
                    </div>

                    <!-- Stat Cards -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                        <!-- Card 1 -->
                        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
                            <div class="relative z-10">
                                <div class="w-12 h-12 rounded-xl bg-blue-50/80 text-blue-600 flex items-center justify-center mb-4 border border-blue-100/50">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <p class="text-sm font-medium text-gray-500 mb-1">Jumlah Keseluruhan</p>
                                <p class="text-3xl font-bold text-gray-800">{{ $data['total_requests'] }}</p>
                            </div>
                        </div>
                        
                        <!-- Card 2 -->
                        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
                            <div class="relative z-10">
                                <div class="w-12 h-12 rounded-xl bg-amber-50/80 text-amber-600 flex items-center justify-center mb-4 border border-amber-100/50">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <p class="text-sm font-medium text-gray-500 mb-1">
                                    {{ $user->role === 'boss' ? 'Menunggu Kelulusan' : 'Menunggu Sokongan' }}
                                </p>
                                <p class="text-3xl font-bold text-gray-800">
                                    {{ $user->role === 'boss' ? $data['pending_boss'] : $data['pending_support'] }}
                                </p>
                            </div>
                        </div>

                        <!-- Card 3 -->
                        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
                            <div class="relative z-10">
                                <div class="w-12 h-12 rounded-xl bg-sky-50/80 text-sky-600 flex items-center justify-center mb-4 border border-sky-100/50">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                </div>
                                <p class="text-sm font-medium text-gray-500 mb-1">
                                    {{ $user->role === 'boss' ? 'Dalam Proses' : 'Sedang Diproses' }}
                                </p>
                                <p class="text-3xl font-bold text-gray-800">
                                    {{ $user->role === 'boss' ? $data['in_process'] : $data['my_pending'] }}
                                </p>
                            </div>
                        </div>

                        <!-- Card 4 -->
                        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
                            <div class="relative z-10">
                                <div class="w-12 h-12 rounded-xl bg-emerald-50/80 text-emerald-600 flex items-center justify-center mb-4 border border-emerald-100/50">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <p class="text-sm font-medium text-gray-500 mb-1">
                                    {{ $user->role === 'boss' ? 'Diluluskan' : 'Berjaya Diluluskan' }}
                                </p>
                                <p class="text-3xl font-bold text-gray-800">
                                    {{ $user->role === 'boss' ? $data['approved'] : $data['my_approved'] }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Main Section: Recent Applications -->
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                        <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/30">
                            <h3 class="text-lg font-semibold text-gray-800">
                                {{ $user->role === 'boss' ? 'Permohonan Memerlukan Tindakan' : 'Senarai Permohonan Saya' }}
                            </h3>
                            <a href="{{ route('fund-requests.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700 bg-blue-50 px-3 py-1.5 rounded-lg transition-colors">Lihat Semua</a>
                        </div>
                        
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="text-gray-400 text-xs uppercase tracking-wider border-b border-gray-100">
                                        <th class="px-6 py-4 font-medium">Tajuk Permohonan</th>
                                        <th class="px-6 py-4 font-medium">Tarikh</th>
                                        <th class="px-6 py-4 font-medium">Pemohon</th>
                                        <th class="px-6 py-4 font-medium">Status</th>
                                        <th class="px-6 py-4 font-medium text-right">Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50 text-sm">
                                    
                                    @forelse($data['recent_requests'] as $request)
                                    <tr class="hover:bg-gray-50/80 transition-colors group">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center text-gray-500">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m3-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                                </div>
                                                <div>
                                                    <p class="font-semibold text-gray-800">{{ $request->programReport->name_of_program }}</p>
                                                    <p class="text-xs text-gray-500 mt-0.5">ID: PR-{{ $request->id }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-gray-600">{{ $request->created_at->format('d M Y') }}</td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-2">
                                                <div class="w-6 h-6 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-xs font-bold">
                                                    {{ strtoupper(substr($request->requester->name, 0, 1)) }}
                                                </div>
                                                <span class="text-gray-700 font-medium">{{ $request->requester->name }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            @php
                                                $statusClasses = [
                                                    'pending_members' => 'bg-amber-50 text-amber-600 border-amber-100',
                                                    'pending_boss' => 'bg-sky-50 text-sky-600 border-sky-100',
                                                    'approved_by_boss' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                                    'rejected' => 'bg-red-50 text-red-600 border-red-100',
                                                ];
                                                $statusLabels = [
                                                    'pending_members' => 'Sokongan Ahli (' . $request->total_member_approvals . '/18)',
                                                    'pending_boss' => 'Menunggu Boss',
                                                    'approved_by_boss' => 'Diluluskan',
                                                    'rejected' => 'Ditolak',
                                                ];
                                            @endphp
                                            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium border {{ $statusClasses[$request->status] ?? 'bg-gray-100 text-gray-600' }}">
                                                <span class="w-1.5 h-1.5 rounded-full {{ str_replace('text', 'bg', explode(' ', $statusClasses[$request->status] ?? 'bg-gray-500')[1]) }}"></span>
                                                {{ $statusLabels[$request->status] ?? $request->status }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <a href="{{ route('fund-requests.show', $request->id) }}" class="text-blue-600 hover:bg-blue-50 px-3 py-1.5 rounded-lg font-medium transition-colors opacity-0 group-hover:opacity-100">Semak</a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                            Tiada permohonan terkini ditemui.
                                        </td>
                                    </tr>
                                    @endforelse

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
            
        </main>
    </div>
</body>
</html>
