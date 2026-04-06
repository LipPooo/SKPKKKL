@extends('layouts.app')

@section('title', 'Senarai Permohonan Dana - SKPKKKL')

@section('content')
<div class="max-w-7xl mx-auto">
    
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[800px]">
                <thead>
                    <tr class="text-gray-400 text-xs uppercase tracking-wider border-b border-gray-100">
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
                            <p class="font-semibold text-gray-800">{{ $request->programReport->name_of_program }}</p>
                            <p class="text-xs text-gray-500 mt-0.5 font-mono uppercase">ID: PR-{{ $request->id }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-xs font-bold border border-blue-200 shadow-sm">
                                    {{ strtoupper(substr($request->requester->name, 0, 1)) }}
                                </div>
                                <span class="text-gray-700 font-semibold">{{ $request->requester->name }}</span>
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
    </div>

</div>
@endsection

