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
            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PATCH')
                
                <!-- Profile Photo Section -->
                <div class="flex flex-col sm:flex-row items-center gap-6 pb-6 border-b border-gray-50" x-data="{ imageUrl: '{{ auth()->user()->profile_photo_url }}' }">
                    <div class="relative group">
                        <img :src="imageUrl" alt="Profile" class="w-24 h-24 rounded-2xl object-cover border-4 border-gray-50 shadow-sm transition-all group-hover:border-blue-100">
                        <label for="profile_photo" class="absolute inset-0 flex items-center justify-center bg-black/40 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </label>
                        <input type="file" name="profile_photo" id="profile_photo" class="sr-only" accept="image/*" @change="imageUrl = URL.createObjectURL($event.target.files[0])">
                    </div>
                    <div class="text-center sm:text-left space-y-1">
                        <p class="text-sm font-bold text-gray-900">Gambar Profil</p>
                        <p class="text-[10px] text-gray-500 font-medium leading-relaxed">Klik pada gambar untuk menukar. <br> Format JPG, PNG (Max. 10MB)</p>
                        @error('profile_photo') <p class="text-red-500 text-[10px] mt-1 font-bold">{{ $message }}</p> @enderror
                        
                        @if(Auth::user()->profile_photo_path)
                            <div class="mt-2 text-left">
                                <form action="{{ route('profile.photo.destroy') }}" method="POST" onsubmit="return confirm('Padam gambar profil anda?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-700 text-[10px] font-bold uppercase tracking-wider flex items-center gap-1.5 transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        Padam Gambar
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4">
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

