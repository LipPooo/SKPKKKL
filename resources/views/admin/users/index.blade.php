@extends('layouts.app')

@section('title', 'Pengurusan Pengguna - SKPKKKL')

@section('content')
<div class="max-w-7xl mx-auto space-y-8" x-data="{ selected: [] }">
    
    <!-- Floating Bulk Action Bar -->
    <div x-show="selected.length > 0" x-transition.opacity.scale.90 class="fixed bottom-8 left-1/2 -translate-x-1/2 z-50 bg-gray-900 text-white px-6 py-4 rounded-2xl shadow-xl flex items-center gap-4 border border-gray-800" style="display: none;" x-cloak>
        <span class="font-bold text-sm whitespace-nowrap"><span x-text="selected.length"></span> akaun dipilih</span>
        <div class="h-6 w-px bg-gray-700"></div>
        
        <form action="{{ route('admin.users.bulk-approve') }}" method="POST" class="inline m-0 p-0" onsubmit="return confirm('Kelulusan Pukal: Adakah anda pasti mahu meluluskan ' + selected.length + ' akaun yang dipilih?')">
            @csrf
            <template x-for="id in selected">
                <input type="hidden" name="user_ids[]" :value="id">
            </template>
            <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 px-4 py-2 rounded-xl font-bold text-[10px] sm:text-xs uppercase tracking-wider transition-colors whitespace-nowrap">
                Lulus
            </button>
        </form>

        <form action="{{ route('admin.users.bulk') }}" method="POST" class="inline m-0 p-0" onsubmit="return confirm('Padam Pukal: Adakah anda pasti mahu memadam ' + selected.length + ' akaun yang dipilih?')">
            @csrf
            @method('DELETE')
            <template x-for="id in selected">
                <input type="hidden" name="user_ids[]" :value="id">
            </template>
            <button type="submit" class="bg-red-500 hover:bg-red-600 px-4 py-2 rounded-xl font-bold text-[10px] sm:text-xs uppercase tracking-wider transition-colors whitespace-nowrap">
                Padam
            </button>
        </form>
    </div>
    
    <!-- Pending Users Section -->
    <div>
        <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
            <span class="w-3 h-3 rounded-full bg-amber-500 shadow-sm shadow-amber-500/20"></span>
            Menunggu Kelulusan ({{ $pendingUsers->count() }})
        </h2>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden min-w-0">
            <!-- Table for Desktop -->
            <div class="overflow-x-auto hidden md:block">
                <table class="w-full text-left border-collapse min-w-[700px]">
                    <thead>
                        <tr class="text-gray-400 text-xs uppercase tracking-wider border-b border-gray-100 bg-gray-50/10">
                            <th class="px-6 py-4 w-12 text-center">
                                <input type="checkbox" @click="selected = $event.target.checked ? [...new Set(Array.from(document.querySelectorAll('.user-cb')).map(cb => cb.value))] : []" class="rounded border-gray-300 text-rose-600 focus:ring-rose-500 cursor-pointer w-4 h-4">
                            </th>
                            <th class="px-6 py-4 font-medium">Pengguna</th>
                            <th class="px-6 py-4 font-medium">No Pekerja</th>
                            <th class="px-6 py-4 font-medium">Email</th>
                            <th class="px-6 py-4 font-medium">Tarikh Daftar</th>
                            <th class="px-6 py-4 font-medium text-right">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-sm">
                        @forelse($pendingUsers as $user)
                        <tr class="hover:bg-gray-50/80 transition-colors group">
                            <td class="px-6 py-4 text-center">
                                <input type="checkbox" value="{{ $user->id }}" x-model="selected" class="user-cb rounded border-gray-300 text-rose-600 focus:ring-rose-500 cursor-pointer w-4 h-4">
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" class="w-8 h-8 rounded-lg object-cover border border-gray-100 shadow-sm">
                                    <span class="font-bold text-gray-800">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-600 font-mono">{{ $user->employee_id }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $user->email }}</td>
                            <td class="px-6 py-4 text-gray-500 text-xs font-medium">{{ $user->created_at->format('d/m/Y, g:i A') }}</td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="text-sky-600 hover:bg-sky-50 px-3 py-1.5 rounded-lg font-bold transition-colors text-xs uppercase tracking-wider">
                                    Kemaskini
                                </a>
                                <form action="{{ route('admin.users.approve', $user->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-emerald-600 hover:bg-emerald-50 px-3 py-1.5 rounded-lg font-bold transition-colors text-xs uppercase tracking-wider">
                                        Lulus
                                    </button>
                                </form>
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Adakah anda pasti?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:bg-red-50 px-3 py-1.5 rounded-lg font-bold transition-colors text-xs uppercase tracking-wider text-right">
                                        Padam
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">Tiada pendaftaran menunggu kelulusan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Cards for Mobile -->
            <div class="md:hidden divide-y divide-gray-100">
                @forelse($pendingUsers as $user)
                <div class="p-5 space-y-4 relative">
                    <div class="absolute top-4 right-4 z-10">
                        <input type="checkbox" value="{{ $user->id }}" x-model="selected" class="user-cb rounded border-gray-300 text-rose-600 focus:ring-rose-500 cursor-pointer w-5 h-5 shadow-sm">
                    </div>
                    <div class="flex items-start gap-4">
                        <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" class="w-12 h-12 rounded-xl object-cover border border-gray-100 shadow-sm">
                        <div class="min-w-0 flex-1">
                            <p class="font-bold text-gray-900 truncate">{{ $user->name }}</p>
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-1">No Pekerja: {{ $user->employee_id }}</p>
                            <p class="text-[10px] text-gray-500 mt-0.5 truncate">{{ $user->email }}</p>
                            <p class="text-[9px] text-gray-400 mt-1 font-medium italic">Daftar: {{ $user->created_at->format('d M Y, h:i A') }}</p>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="flex-1 bg-sky-50 text-sky-600 py-3 rounded-xl font-bold text-center text-[10px] uppercase tracking-widest border border-sky-100 shadow-sm active:scale-95 transition-all">
                            Kemaskini
                        </a>
                        <form action="{{ route('admin.users.approve', $user->id) }}" method="POST" class="flex-1">
                            @csrf
                            <button type="submit" class="w-full bg-emerald-50 text-emerald-600 py-3 rounded-xl font-bold text-[10px] uppercase tracking-widest border border-emerald-100 shadow-sm active:scale-95 transition-all">
                                Lulus
                            </button>
                        </form>
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Adakah anda pasti?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full bg-red-50 text-red-600 py-3 rounded-xl font-bold text-[10px] uppercase tracking-widest border border-red-100 shadow-sm active:scale-95 transition-all">
                                Padam
                            </button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="p-12 text-center text-gray-500 text-sm">
                    Tiada pendaftaran menunggu kelulusan.
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Approved Users Section -->
    <div class="pt-4">
        <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
            <span class="w-3 h-3 rounded-full bg-emerald-500 shadow-sm shadow-emerald-500/20"></span>
            Pengguna Berdaftar ({{ $approvedUsers->count() }})
        </h2>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden min-w-0">
            <!-- Table for Desktop -->
            <div class="overflow-x-auto hidden md:block">
                <table class="w-full text-left border-collapse min-w-[700px]">
                    <thead>
                        <tr class="text-gray-400 text-xs uppercase tracking-wider border-b border-gray-100 bg-gray-50/10">
                            <th class="px-6 py-4 w-12 text-center">
                                <input type="checkbox" disabled class="rounded border-gray-200 bg-gray-100 w-4 h-4" title="Pilih semua (Global)">
                            </th>
                            <th class="px-6 py-4 font-medium">Pengguna</th>
                            <th class="px-6 py-4 font-medium">No Pekerja</th>
                            <th class="px-6 py-4 font-medium">Email</th>
                            <th class="px-6 py-4 font-medium">Peranan</th>
                            <th class="px-6 py-4 font-medium">Tarikh Daftar</th>
                            <th class="px-6 py-4 font-medium text-right">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-sm">
                        @foreach($approvedUsers as $user)
                        <tr class="hover:bg-gray-50/80 transition-colors group">
                            <td class="px-6 py-4 text-center">
                                @if($user->id !== Auth::id())
                                    <input type="checkbox" value="{{ $user->id }}" x-model="selected" class="user-cb rounded border-gray-300 text-rose-600 focus:ring-rose-500 cursor-pointer w-4 h-4">
                                @else
                                    <input type="checkbox" disabled class="rounded border-gray-200 bg-gray-100 cursor-not-allowed w-4 h-4" title="Anda tidak boleh padam diri sendiri">
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" class="w-8 h-8 rounded-lg object-cover border border-gray-100 shadow-sm">
                                    <span class="font-bold text-gray-800">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-600 font-mono">{{ $user->employee_id }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $user->email }}</td>
                            <td class="px-6 py-4 text-gray-600 capitalize">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $user->role === 'boss' ? 'bg-purple-50 text-purple-600 border border-purple-100' : 'bg-rose-50 text-rose-600 border border-rose-100' }}">
                                    {{ $user->role === 'boss' ? 'Pengerusi' : 'Ahli Jawatankuasa' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-500 text-xs font-medium">{{ $user->created_at->format('d/m/Y, g:i A') }}</td>
                            <td class="px-6 py-4 text-right flex justify-end gap-2">
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="text-sky-600 hover:bg-sky-50 px-3 py-1.5 rounded-lg font-bold transition-colors text-xs uppercase tracking-wider text-right">
                                    Kemaskini
                                </a>
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

            <!-- Cards for Mobile -->
            <div class="md:hidden divide-y divide-gray-100">
                @foreach($approvedUsers as $user)
                <div class="p-5 space-y-4 relative">
                    @if($user->id !== Auth::id())
                    <div class="absolute top-4 right-4 z-10">
                        <input type="checkbox" value="{{ $user->id }}" x-model="selected" class="user-cb rounded border-gray-300 text-rose-600 focus:ring-rose-500 cursor-pointer w-5 h-5 shadow-sm">
                    </div>
                    @endif
                    <div class="flex items-start gap-4">
                        <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" class="w-12 h-12 rounded-xl object-cover border border-gray-100 shadow-sm">
                        <div class="min-w-0 flex-1">
                            <div class="flex items-center gap-2 mb-1.5">
                                <span class="px-2 py-0.5 rounded-full text-[9px] font-bold uppercase tracking-wider {{ $user->role === 'boss' ? 'bg-purple-100 text-purple-700' : 'bg-rose-100 text-rose-700' }}">
                                    {{ $user->role === 'boss' ? 'Pengerusi' : 'AJK' }}
                                </span>
                            </div>
                            <p class="font-bold text-gray-900 truncate">{{ $user->name }}</p>
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-1">No Pekerja: {{ $user->employee_id }}</p>
                            <p class="text-[10px] text-gray-500 mt-0.5 truncate">{{ $user->email }}</p>
                            <p class="text-[9px] text-gray-400 mt-1 font-medium italic">Daftar: {{ $user->created_at->format('d M Y, h:i A') }}</p>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="flex-1 bg-sky-50 text-sky-600 py-3 rounded-xl font-bold text-center text-[10px] uppercase tracking-widest border border-sky-100 shadow-sm active:scale-95 transition-all">
                            Kemaskini
                        </a>
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Adakah anda pasti?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full bg-red-50 text-red-600 py-3 rounded-xl font-bold text-[10px] uppercase tracking-widest border border-red-100 shadow-sm active:scale-95 transition-all">
                                Padam Akaun
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    
</div>
@endsection

