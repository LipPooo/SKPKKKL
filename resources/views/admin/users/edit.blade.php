@extends('layouts.app')

@section('title', 'Kemaskini Pengguna - SKPKKKL')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-rose-600 transition-colors">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Kembali ke Senarai
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-50 bg-gray-50/50">
            <div class="flex items-center gap-4">
                <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" class="w-12 h-12 rounded-xl object-cover border-2 border-white shadow-sm">
                <div>
                    <h3 class="font-bold text-gray-900">Kemaskini Akaun Pengguna</h3>
                    <p class="text-[10px] text-gray-500 font-medium uppercase tracking-wider mt-0.5">Sila kemaskini maklumat pengguna di bawah.</p>
                </div>
            </div>
        </div>
        
        <div class="p-6 sm:p-8">
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PATCH')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label for="name" class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 text-left">Nama Penuh</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                            class="w-full rounded-xl border-gray-200 text-sm focus:border-rose-500 focus:ring-rose-500 bg-gray-50/50 px-4 py-3">
                        @error('name') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="employee_id" class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 text-left">No Pekerja</label>
                        <input type="text" name="employee_id" id="employee_id" value="{{ old('employee_id', $user->employee_id) }}" required
                            class="w-full rounded-xl border-gray-200 text-sm focus:border-rose-500 focus:ring-rose-500 bg-gray-50/50 px-4 py-3 font-mono">
                        @error('employee_id') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="role" class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 text-left">Peranan</label>
                        <select name="role" id="role" required
                            class="w-full rounded-xl border-gray-200 text-sm focus:border-rose-500 focus:ring-rose-500 bg-gray-50/50 px-4 py-3">
                            <option value="member" {{ old('role', $user->role) === 'member' ? 'selected' : '' }}>Ahli Jawatankuasa (AJK)</option>
                            <option value="boss" {{ old('role', $user->role) === 'boss' ? 'selected' : '' }}>Pengerusi</option>
                        </select>
                        @error('role') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="email" class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 text-left">Alamat Emel</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                            class="w-full rounded-xl border-gray-200 text-sm focus:border-rose-500 focus:ring-rose-500 bg-gray-50/50 px-4 py-3">
                        @error('email') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-50 space-y-4">
                    <div class="p-4 bg-amber-50 rounded-xl border border-amber-100/50">
                        <p class="text-[10px] font-bold text-amber-700 uppercase tracking-widest mb-1">Tukar Kata Laluan (Pilihan)</p>
                        <p class="text-[10px] text-amber-600 font-medium">Kosongkan jika tidak mahu menukar kata laluan pengguna.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="password" class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 text-left">Kata Laluan Baru</label>
                            <input type="password" name="password" id="password"
                                class="w-full rounded-xl border-gray-200 text-sm focus:border-rose-500 focus:ring-rose-500 bg-gray-50/50 px-4 py-3"
                                placeholder="Min. 8 aksara">
                            @error('password') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 text-left">Sahkan Kata Laluan</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="w-full rounded-xl border-gray-200 text-sm focus:border-rose-500 focus:ring-rose-500 bg-gray-50/50 px-4 py-3"
                                placeholder="Ulang kata laluan">
                        </div>
                    </div>
                </div>

                <div class="flex justify-end pt-4">
                    <button type="submit" class="w-full sm:w-auto bg-rose-600 hover:bg-rose-700 text-white px-8 py-3 rounded-xl font-bold transition-all shadow-lg shadow-rose-600/20 text-xs uppercase tracking-wider">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
