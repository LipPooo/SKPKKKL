@extends('layouts.app')

@section('title', 'Senarai Permohonan Dana - SKPKKKL')

@section('content')
<div class="max-w-7xl mx-auto">
    
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden min-w-0">
        <!-- Table for Desktop -->
        <div class="overflow-x-auto hidden md:block">
            <table class="w-full text-left border-collapse min-w-[800px]">
                <thead>
                    <tr class="text-gray-400 text-xs uppercase tracking-wider border-b border-gray-100 font-bold bg-gray-50/10">
                        <th class="px-6 py-4 font-medium">Program</th>
                        <th class="px-6 py-4 font-medium">Pemohon</th>
                        <th class="px-6 py-4 font-medium">Bajet</th>
                        <th class="px-6 py-4 font-medium">Status</th>
                        <th class="px-6 py-4 font-medium text-right">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 text-sm">
                    @forelse($requests as $request)
                    <tr class="hover:bg-gray-50/80 transition-colors group">
                        <td class="px-6 py-4">
                            <p class="font-bold text-gray-800">{{ $request->programReport->name_of_program }}</p>
                            <p class="text-[10px] text-gray-400 mt-0.5 font-bold uppercase tracking-wider">ID: PR-{{ $request->id }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2.5">
                                <img src="{{ $request->requester->profile_photo_url }}" 
                                     alt="{{ $request->requester->name }}" 
                                     class="w-8 h-8 rounded-lg object-cover border border-gray-100 shadow-sm">
                                <span class="text-gray-700 font-bold">{{ $request->requester->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 font-bold text-gray-900">
                            RM {{ number_format($request->programReport->budget, 2) }}
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
                                    'pending_boss' => 'Menunggu Pengerusi',
                                    'approved_by_boss' => 'Diluluskan',
                                    'rejected' => 'Ditolak',
                                ];
                            @endphp
                            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider border {{ $statusClasses[$request->status] ?? 'bg-gray-100 text-gray-600' }}">
                                {{ $statusLabels[$request->status] ?? $request->status }}
                            </div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('fund-requests.show', $request->id) }}" class="text-blue-600 hover:bg-blue-50 px-3 py-1.5 rounded-lg font-bold transition-colors text-xs uppercase tracking-wider">
                                Papar
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-20 text-center text-gray-500">Tiada permohonan dana ditemui.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Cards for Mobile -->
        <div class="md:hidden divide-y divide-gray-100">
            @forelse($requests as $request)
            @php
                $statusClasses = [
                    'pending_members' => 'bg-amber-100 text-amber-700',
                    'pending_boss' => 'bg-sky-100 text-sky-700',
                    'approved_by_boss' => 'bg-emerald-100 text-emerald-700',
                    'rejected' => 'bg-red-100 text-red-700',
                ];
                $statusLabels = [
                    'pending_members' => 'Sokongan Ahli (' . $request->total_member_approvals . '/18)',
                    'pending_boss' => 'Tunggu Pengerusi',
                    'approved_by_boss' => 'Diluluskan',
                    'rejected' => 'Ditolak',
                ];
            @endphp
            <div class="p-5 space-y-4">
                <div class="flex justify-between items-start gap-4">
                    <div class="min-w-0 flex-1">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="px-2 py-0.5 rounded-full text-[9px] font-bold uppercase tracking-wider {{ $statusClasses[$request->status] ?? 'bg-gray-100 text-gray-700' }}">
                                {{ $statusLabels[$request->status] ?? $request->status }}
                            </span>
                        </div>
                        <p class="font-bold text-gray-900 leading-snug mb-1">{{ $request->programReport->name_of_program }}</p>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">ID: PR-{{ $request->id }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-[10px] text-gray-400 uppercase font-bold tracking-widest mb-0.5">Bajet</p>
                        <p class="font-bold text-gray-900 text-sm">RM {{ number_format($request->programReport->budget, 2) }}</p>
                    </div>
                </div>

                <div class="flex items-center gap-3 bg-gray-50/50 p-3 rounded-xl border border-gray-100">
                    <img src="{{ $request->requester->profile_photo_url }}" 
                         alt="{{ $request->requester->name }}" 
                         class="w-9 h-9 rounded-lg object-cover border border-white shadow-sm">
                    <div>
                        <p class="text-[9px] text-gray-400 uppercase font-bold tracking-widest">Pemohon</p>
                        <p class="text-xs font-bold text-gray-700">{{ $request->requester->name }}</p>
                    </div>
                </div>

                <a href="{{ route('fund-requests.show', $request->id) }}" class="block w-full text-center bg-blue-600 text-white py-3 rounded-xl font-bold text-[10px] uppercase tracking-widest shadow-lg shadow-blue-600/20 active:scale-95 transition-all">
                    Papar Butiran
                </a>
            </div>
            @empty
            <div class="p-12 text-center text-gray-500 text-sm">
                Tiada permohonan dana ditemui.
            </div>
            @endforelse
        </div>
    </div>

</div>
@endsection

