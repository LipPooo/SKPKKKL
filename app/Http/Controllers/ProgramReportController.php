<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ProgramReport;
use App\Models\FundRequest;
use App\Models\User;
use App\Notifications\NewFundRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

use Illuminate\Support\Facades\Storage;

class ProgramReportController extends Controller
{
    public function index()
    {
        $reports = ProgramReport::latest()->get();
        return view('program_reports.index', compact('reports'));
    }

    public function create()
    {
        $users = User::orderBy('name')->get();
        return view('program_reports.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_of_program' => 'required|string|max:255',
            'date' => 'required|date',
            'type' => 'required|in:sukan,sosial',
            'location' => 'required|string|max:255',
            'total_members_involved' => 'required|integer|min:0',
            'total_non_members' => 'nullable|integer|min:0',
            'vip_details' => 'nullable|string',
            'total_participation' => 'required|integer|min:0',
            'collaboration' => 'nullable|string',
            'organizer' => 'required|in:KKKL,TNB,Luar',
            'budget' => 'required|numeric|min:0',
            'payment_details' => 'nullable|string',
            'pic_user_id' => 'required|exists:users,id',
            'recognition' => 'nullable|string',
            'image_proof' => 'required|file|mimes:jpeg,png,jpg,pdf|max:10240',
        ]);

        $path = $request->file('image_proof')->store('proofs', 'public');

        $report = ProgramReport::create([
            'user_id' => Auth::id(),
            'name_of_program' => $request->name_of_program,
            'date' => $request->date,
            'type' => $request->type,
            'location' => $request->location,
            'total_members_involved' => $request->total_members_involved,
            'total_non_members' => $request->total_non_members,
            'vip_details' => $request->vip_details,
            'total_participation' => $request->total_participation,
            'collaboration' => $request->collaboration,
            'organizer' => $request->organizer,
            'budget' => $request->budget,
            'payment_details' => $request->payment_details,
            'pic_user_id' => $request->pic_user_id,
            'recognition' => $request->recognition,
            'image_proof_path' => $path,
        ]);

        // Auto create fund request
        $fundRequest = FundRequest::create([
            'program_report_id' => $report->id,
            'requester_id' => Auth::id(),
            'total_member_approvals' => 0,
            'status' => 'pending_members',
        ]);

        // Notify all other members
        $members = User::where('role', 'member')->where('id', '!=', Auth::id())->get();
        Notification::send($members, new NewFundRequest($fundRequest));

        return redirect()->route('program-reports.index')->with('success', 'Laporan Program dan Permohonan Dana berjaya direkodkan.');
    }

    public function show($id)
    {
        $report = ProgramReport::findOrFail($id);
        return view('program_reports.show', compact('report'));
    }

    public function destroy($id)
    {
        $report = ProgramReport::findOrFail($id);

        // Security Check: Only admin or the owner can delete
        if (!Auth::user()->isAdmin() && Auth::id() !== $report->user_id) {
            abort(403, 'Anda tidak mempunyai kebenaran untuk memadam laporan ini.');
        }

        // Delete associated prove file
        if ($report->image_proof_path) {
            Storage::disk('public')->delete($report->image_proof_path);
        }

        // Delete the report (Cascade should handle FundRequest if configured, but let's be explicit if not)
        if ($report->fundRequest) {
            $report->fundRequest()->delete();
        }

        $report->delete();

        return redirect()->route('program-reports.index')->with('success', 'Laporan Program telah berjaya dipadam.');
    }

    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'report_ids' => 'required|array',
            'report_ids.*' => 'exists:program_reports,id',
        ]);

        $deletedCount = 0;

        foreach ($request->report_ids as $id) {
            $report = ProgramReport::find($id);
            if ($report) {
                // Security Check: Only admin or the owner can delete
                if (Auth::user()->isAdmin() || Auth::id() === $report->user_id) {
                    if ($report->image_proof_path) {
                        Storage::disk('public')->delete($report->image_proof_path);
                    }
                    if ($report->fundRequest) {
                        $report->fundRequest()->delete();
                    }
                    $report->delete();
                    $deletedCount++;
                }
            }
        }

        return redirect()->route('program-reports.index')->with('success', $deletedCount . ' Laporan Program telah berjaya dipadam.');
    }

    public function print($id)
    {
        $report = ProgramReport::findOrFail($id);
        return view('program_reports.print', compact('report'));
    }

    public function printAll()
    {
        $reports = ProgramReport::latest()->get();
        return view('program_reports.print_all', compact('reports'));
    }
}
