@extends('layouts.app')

@section('title', 'Tetapan Profil - SKPKKKL')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    
    <!-- Profile Information -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden text-sm">
        <div class="p-6 border-b border-gray-50 bg-gray-50/50">
            <h3 class="font-bold text-gray-900">Maklumat Profil</h3>
            <p class="text-[10px] text-gray-500 font-medium uppercase tracking-wider mt-1">Kemaskini nama dan alamat emel akaun anda.</p>
        </div>
        <div class="p-6 sm:p-8">
            <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
                @csrf
                @method('PATCH')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Nama Penuh</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                            class="w-full rounded-xl border-gray-200 text-sm focus:border-blue-500 focus:ring-blue-500 bg-gray-50/50 px-4 py-3">
                        @error('name') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label for="email" class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Alamat Emel</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                            class="w-full rounded-xl border-gray-200 text-sm focus:border-blue-500 focus:ring-blue-500 bg-gray-50/50 px-4 py-3">
                        @error('email') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="flex justify-end pt-4">
                    <button type="submit" class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl font-bold transition-all shadow-lg shadow-blue-600/20 text-xs uppercase tracking-wider">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Update Password -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden text-sm">
        <div class="p-6 border-b border-gray-50 bg-gray-50/50">
            <h3 class="font-bold text-gray-900 text-sm">Kemaskini Kata Laluan</h3>
            <p class="text-[10px] text-gray-500 font-medium uppercase tracking-wider mt-1">Pastikan akaun anda menggunakan kata laluan yang panjang dan rawak.</p>
        </div>
        <div class="p-6 sm:p-8">
            <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
                @csrf
                @method('PUT')
                
                <div class="max-w-xl space-y-6">
                    <div>
                        <label for="current_password" class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Kata Laluan Semasa</label>
                        <input type="password" name="current_password" id="current_password" required
                            class="w-full rounded-xl border-gray-200 text-sm focus:border-blue-500 focus:ring-blue-500 bg-gray-50/50 px-4 py-3">
                        @error('current_password') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label for="password" class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Kata Laluan Baru</label>
                        <input type="password" name="password" id="password" required
                            class="w-full rounded-xl border-gray-200 text-sm focus:border-blue-500 focus:ring-blue-500 bg-gray-50/50 px-4 py-3">
                        @error('password') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Sahkan Kata Laluan Baru</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                            class="w-full rounded-xl border-gray-200 text-sm focus:border-blue-500 focus:ring-blue-500 bg-gray-50/50 px-4 py-3">
                    </div>
                </div>

                <div class="flex justify-end pt-4">
                    <button type="submit" class="w-full sm:w-auto bg-gray-900 hover:bg-black text-white px-8 py-3 rounded-xl font-bold transition-all shadow-lg shadow-black/20 text-xs uppercase tracking-wider">
                        Tukar Kata Laluan
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection

