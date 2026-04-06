@extends('layouts.app')

@section('title', 'Pengurusan Pengguna - SKPKKKL')

@section('content')
<div class="max-w-7xl mx-auto space-y-8">
    
    <!-- Pending Users Section -->
    <div>
        <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
            <span class="w-3 h-3 rounded-full bg-amber-500 shadow-sm shadow-amber-500/20"></span>
            Menunggu Kelulusan ({{ $pendingUsers->count() }})
        </h2>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[700px]">
                    <thead>
                        <tr class="text-gray-400 text-xs uppercase tracking-wider border-b border-gray-100 bg-gray-50/10">
                            <th class="px-6 py-4 font-medium">Nama</th>
                            <th class="px-6 py-4 font-medium">No Pekerja</th>
                            <th class="px-6 py-4 font-medium">Email</th>
                            <th class="px-6 py-4 font-medium text-right">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-sm">
                        @forelse($pendingUsers as $user)
                        <tr class="hover:bg-gray-50/80 transition-colors group">
                            <td class="px-6 py-4 font-bold text-gray-800">{{ $user->name }}</td>
                            <td class="px-6 py-4 text-gray-600 font-mono">{{ $user->employee_id }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $user->email }}</td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <form action="{{ route('admin.users.approve', $user->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-emerald-600 hover:bg-emerald-50 px-3 py-1.5 rounded-lg font-bold transition-colors text-xs uppercase tracking-wider">
                                        Lulus
                                    </button>
                                </form>
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Adakah anda pasti?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:bg-red-50 px-3 py-1.5 rounded-lg font-bold transition-colors text-xs uppercase tracking-wider">
                                        Padam
                                    </button>
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
    </div>

    <!-- Approved Users Section -->
    <div class="pt-4">
        <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
            <span class="w-3 h-3 rounded-full bg-emerald-500 shadow-sm shadow-emerald-500/20"></span>
            Pengguna Berdaftar ({{ $approvedUsers->count() }})
        </h2>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[700px]">
                    <thead>
                        <tr class="text-gray-400 text-xs uppercase tracking-wider border-b border-gray-100 bg-gray-50/10">
                            <th class="px-6 py-4 font-medium">Nama</th>
                            <th class="px-6 py-4 font-medium">No Pekerja</th>
                            <th class="px-6 py-4 font-medium">Peranan</th>
                            <th class="px-6 py-4 font-medium text-right">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-sm">
                        @foreach($approvedUsers as $user)
                        <tr class="hover:bg-gray-50/80 transition-colors group">
                            <td class="px-6 py-4 font-bold text-gray-800">{{ $user->name }}</td>
                            <td class="px-6 py-4 text-gray-600 font-mono">{{ $user->employee_id }}</td>
                            <td class="px-6 py-4 text-gray-600 capitalize">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $user->role === 'boss' ? 'bg-purple-50 text-purple-600 border border-purple-100' : 'bg-blue-50 text-blue-600 border border-blue-100' }}">
                                    {{ $user->role === 'boss' ? 'Pengerusi' : 'Ajawatankuasa' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Adakah anda pasti?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:bg-red-50 px-3 py-1.5 rounded-lg font-bold transition-colors text-xs uppercase tracking-wider">
                                        Padam
                                    </button>
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
@endsection

