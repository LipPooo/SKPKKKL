<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pengurusan Pengguna - SKPKKKL</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased">
    <div class="flex h-screen overflow-hidden">
        
        @include('partials.sidebar')

        <!-- Main Content -->
        <main class="flex-1 flex flex-col relative overflow-hidden">
            @include('partials.header', ['title' => 'Pengurusan Pengguna'])

            <div class="flex-1 overflow-y-auto w-full p-6 sm:p-8">
                <div class="max-w-7xl mx-auto space-y-8">
                    
                    @if(session('success'))
                    <div class="mb-6 bg-emerald-50 border border-emerald-100 text-emerald-600 px-4 py-3 rounded-xl text-sm flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        {{ session('success') }}
                    </div>
                    @endif

                    <!-- Pending Users Section -->
                    <div>
                        <h2 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                            Menunggu Kelulusan ({{ $pendingUsers->count() }})
                        </h2>
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="text-gray-400 text-xs uppercase tracking-wider border-b border-gray-100 bg-gray-50/30">
                                        <th class="px-6 py-4 font-medium">Nama</th>
                                        <th class="px-6 py-4 font-medium">No Pekerja</th>
                                        <th class="px-6 py-4 font-medium">Email</th>
                                        <th class="px-6 py-4 font-medium text-right">Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50 text-sm">
                                    @forelse($pendingUsers as $user)
                                    <tr class="hover:bg-gray-50/80 transition-colors group">
                                        <td class="px-6 py-4 font-semibold text-gray-800">{{ $user->name }}</td>
                                        <td class="px-6 py-4 text-gray-600">{{ $user->employee_id }}</td>
                                        <td class="px-6 py-4 text-gray-600">{{ $user->email }}</td>
                                        <td class="px-6 py-4 text-right space-x-2">
                                            <form action="{{ route('admin.users.approve', $user->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="text-emerald-600 hover:bg-emerald-50 px-3 py-1.5 rounded-lg font-medium transition-colors">Kelulusan</button>
                                            </form>
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Adakah anda pasti?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:bg-red-50 px-3 py-1.5 rounded-lg font-medium transition-colors">Padam</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-12 text-center text-gray-500">Tiada pendaftaran menunggu kelulusan.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Approved Users Section -->
                    <div class="pt-4">
                        <h2 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            Pengguna Berdaftar ({{ $approvedUsers->count() }})
                        </h2>
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="text-gray-400 text-xs uppercase tracking-wider border-b border-gray-100 bg-gray-50/30">
                                        <th class="px-6 py-4 font-medium">Nama</th>
                                        <th class="px-6 py-4 font-medium">No Pekerja</th>
                                        <th class="px-6 py-4 font-medium">Peranan</th>
                                        <th class="px-6 py-4 font-medium text-right">Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50 text-sm">
                                    @foreach($approvedUsers as $user)
                                    <tr class="hover:bg-gray-50/80 transition-colors group">
                                        <td class="px-6 py-4 font-semibold text-gray-800">{{ $user->name }}</td>
                                        <td class="px-6 py-4 text-gray-600">{{ $user->employee_id }}</td>
                                        <td class="px-6 py-4 text-gray-600 capitalize">
                                            <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $user->role === 'boss' ? 'bg-purple-50 text-purple-600' : 'bg-blue-50 text-blue-600' }}">
                                                {{ $user->role }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Adakah anda pasti?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:bg-red-50 px-3 py-1.5 rounded-lg font-medium transition-colors opacity-0 group-hover:opacity-100">Padam</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
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
