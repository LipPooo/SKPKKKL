@extends('layouts.app')

@section('title', 'Sedia Laporan & Mohon Dana - SKPKKKL')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sm:p-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Maklumat Program & Kewangan</h2>
        <p class="text-gray-500 mb-8 text-sm sm:text-base">Sila lengkapkan laporan program anda. Permohonan dana (fund request) akan dijana secara automatik berdasarkan bajet yang dimasukkan.</p>

        <form action="{{ route('program-reports.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <!-- Grid 1: Basic Info -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="sm:col-span-2">
                    <label class="block text-sm font-bold text-gray-700 mb-1.5">Nama Program</label>
                    <input type="text" name="name_of_program" required class="block w-full rounded-xl border border-gray-200 px-4 py-3 text-sm focus:border-rose-500 focus:ring-1 focus:ring-rose-500 bg-gray-50/50">
                </div>
                 <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1.5">Person In Charge (PIC)</label>
                    <select name="pic_user_id" required class="block w-full rounded-xl border border-gray-200 px-4 py-3 text-sm focus:border-rose-500 focus:ring-1 focus:ring-rose-500 bg-gray-50/50">
                        <option value="">Pilih PIC</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->employee_id ?? 'Tiada ID' }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1.5">Tarikh Program</label>
                    <input type="date" name="date" required class="block w-full rounded-xl border border-gray-200 px-4 py-3 text-sm focus:border-rose-500 focus:ring-1 focus:ring-rose-500 bg-gray-50/50">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1.5">Jenis Program</label>
                    <select name="type" required class="block w-full rounded-xl border border-gray-200 px-4 py-3 text-sm focus:border-rose-500 focus:ring-1 focus:ring-rose-500 bg-gray-50/50">
                        <option value="sukan">Sukan</option>
                        <option value="sosial">Sosial</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1.5">Lokasi</label>
                    <input type="text" name="location" required class="block w-full rounded-xl border border-gray-200 px-4 py-3 text-sm focus:border-rose-500 focus:ring-1 focus:ring-rose-500 bg-gray-50/50">
                </div>
            </div>

            <hr class="border-gray-100 my-4">

            <!-- Grid 2: Participation Details -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1.5">Bil. Ahli Terlibat</label>
                    <input type="number" name="total_members_involved" required class="block w-full rounded-xl border border-gray-200 px-4 py-3 text-sm focus:border-rose-500 focus:ring-1 focus:ring-rose-500 bg-gray-50/50">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1.5">Bil. Bukan Ahli</label>
                    <input type="number" name="total_non_members" class="block w-full rounded-xl border border-gray-200 px-4 py-3 text-sm focus:border-rose-500 focus:ring-1 focus:ring-rose-500 bg-gray-50/50">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1.5">Jumlah Penyertaan</label>
                    <input type="number" name="total_participation" required class="block w-full rounded-xl border border-gray-200 px-4 py-3 text-sm focus:border-rose-500 focus:ring-1 focus:ring-rose-500 bg-gray-50/50">
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1.5">Butiran VIP (Jika Ada)</label>
                <textarea name="vip_details" rows="2" placeholder="Senaraikan VIP yang hadir..." class="block w-full rounded-xl border border-gray-200 px-4 py-3 text-sm focus:border-rose-500 focus:ring-1 focus:ring-rose-500 bg-gray-50/50"></textarea>
            </div>

            <hr class="border-gray-100 my-4">

            <!-- Grid 3: Organizer and Budget -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1.5">Penganjur</label>
                    <select name="organizer" required class="block w-full rounded-xl border border-gray-200 px-4 py-3 text-sm focus:border-rose-500 focus:ring-1 focus:ring-rose-500 bg-gray-50/50">
                        <option value="KKKL">KKKL</option>
                        <option value="TNB">TNB</option>
                        <option value="Luar">Luar</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1.5">Bajet Dipohon (RM)</label>
                    <input type="number" step="0.01" name="budget" required placeholder="0.00" class="block w-full rounded-xl border border-gray-200 px-4 py-3 text-sm focus:border-rose-500 focus:ring-1 focus:ring-rose-500 bg-gray-50/50">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-bold text-gray-700 mb-1.5">Butiran charge code / nPOS / no resit</label>
                    <input type="text" name="payment_details" placeholder="Contoh: POS123 / RES456" class="block w-full rounded-xl border border-gray-200 px-4 py-3 text-sm focus:border-rose-500 focus:ring-1 focus:ring-rose-500 bg-gray-50/50">
                </div>
            </div>

            <div x-data="{ imageUrl: null, fileName: null, isPdf: false }">
                <label class="block text-sm font-bold text-gray-700 mb-1.5">Bukti Gambar / Dokumen (JPG, PNG, PDF)</label>
                
                <!-- Preview Area -->
                <template x-if="imageUrl">
                    <div class="mb-4 relative group">
                        <template x-if="!isPdf">
                            <img :src="imageUrl" class="w-full max-h-64 object-cover rounded-2xl border border-gray-200 shadow-sm">
                        </template>
                        <template x-if="isPdf">
                            <div class="flex items-center gap-3 p-4 bg-rose-50 rounded-xl border border-rose-100 text-rose-700">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a2 2 0 00-2 2v8a2 2 0 002 2h6a2 2 0 002-2V6l-4-4H9z"></path><path d="M10 2v4a1 1 0 001 1h4"></path></svg>
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-wider">Dokumen PDF Dipilih</p>
                                    <p class="text-[10px] opacity-75" x-text="fileName"></p>
                                </div>
                            </div>
                        </template>
                        <button type="button" @click="imageUrl = null; fileName = null; $refs.fileInput.value = ''" 
                                class="absolute top-2 right-2 bg-red-500 text-white p-1.5 rounded-full shadow-lg hover:bg-red-600 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                </template>

                <div x-show="!imageUrl" class="mt-1 flex justify-center px-6 pt-10 pb-10 border-2 border-gray-200 border-dashed rounded-2xl hover:border-rose-400 transition-colors bg-gray-50/30">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-300" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true"><path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg>
                        <div class="flex text-sm text-gray-600 justify-center">
                            <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-bold text-rose-600 hover:text-rose-500 focus-within:outline-none">
                                <span>Muat naik fail</span>
                                <input id="file-upload" name="image_proof" type="file" x-ref="fileInput" class="sr-only" required
                                    @change="
                                        const file = $event.target.files[0];
                                        if (file) {
                                            fileName = file.name;
                                            isPdf = file.type === 'application/pdf';
                                            imageUrl = URL.createObjectURL(file);
                                        }
                                    ">
                            </label>
                            <p class="pl-1">atau tarik dan letak</p>
                        </div>
                        <p class="text-xs text-gray-400 font-medium">PNG, JPG, PDF sehingga 5MB</p>
                    </div>
                </div>
            </div>

            <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 pt-6 border-t border-gray-50">
                <button type="reset" class="w-full sm:w-auto px-6 py-3 rounded-xl text-sm font-bold text-gray-500 hover:bg-gray-100 transition-colors uppercase tracking-wider">Kosongkan</button>
                <button type="submit" class="w-full sm:w-auto px-8 py-3 rounded-xl text-sm font-bold text-white bg-rose-600 shadow-lg shadow-rose-600/20 hover:bg-rose-700 transition-all flex items-center justify-center gap-2 uppercase tracking-wider">
                    Hantar Permohonan
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7m0 0l-7 7m7-7H6"></path></svg>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

