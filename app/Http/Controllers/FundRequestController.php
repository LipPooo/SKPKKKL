<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\FundRequest;
use App\Models\FundRequestApproval;
use App\Models\User;
use App\Notifications\FundRequestReadyForBoss;
use App\Notifications\FundRequestProcessed;
use App\Notifications\FundRequestSupported;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class FundRequestController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'boss') {
            $requests = FundRequest::with(['programReport', 'requester'])
                ->where('status', 'pending_boss')
                ->orWhere('status', 'approved_by_boss')
                ->latest()
                ->get();
        } else {
            // Member sees all pending requests they haven't approved yet, or their own
            $requests = FundRequest::with(['programReport', 'requester'])
                ->latest()
                ->get();
        }

        return view('fund_requests.index', compact('requests'));
    }

    public function create()
    {
        // Redirect to ProgramReport creation since FundRequest depends on it
        return redirect()->route('program-reports.create');
    }

    public function store(Request $request)
    {
        // Redirect to ProgramReport storage logic since it handles both
        return redirect()->route('program-reports.store');
    }

    public function show($id)
    {
        $fundRequest = FundRequest::with(['programReport', 'requester', 'approvals.member'])->findOrFail($id);
        return view('fund_requests.show', compact('fundRequest'));
    }

    public function approve(Request $request, $id)
    {
        $fundRequest = FundRequest::findOrFail($id);
        $user = Auth::user();

        // Cannot approve own request
        if ($fundRequest->requester_id === $user->id) {
            return back()->with('error', 'Anda tidak boleh menyokong permohonan sendiri.');
        }

        // Check if already voted
        if ($fundRequest->approvals()->where('member_id', $user->id)->exists()) {
            return back()->with('error', 'Anda telah pun membuat undian untuk permohonan ini.');
        }

        FundRequestApproval::create([
            'fund_request_id' => $fundRequest->id,
            'member_id' => $user->id,
            'status' => 'approved',
            'reason' => $request->reason // Optional as per user request
        ]);

        $fundRequest->increment('total_member_approvals');

        if ($fundRequest->total_member_approvals >= 18) {
            $fundRequest->update(['status' => 'pending_boss']);
            
            // Notify Boss
            $boss = User::where('role', 'boss')->first();
            if ($boss) {
                $boss->notify(new FundRequestReadyForBoss($fundRequest));
            }
        }

        // Notify Requester that someone supported
        $fundRequest->requester->notify(new FundRequestSupported($fundRequest, $user));

        return redirect()->route('dashboard')->with('success', 'Anda telah menyokong permohonan ini.');
    }

    public function reject(Request $request, $id)
    {
        $fundRequest = FundRequest::findOrFail($id);
        $user = Auth::user();

        if ($fundRequest->approvals()->where('member_id', $user->id)->exists()) {
            return back()->with('error', 'Anda telah pun membuat undian untuk permohonan ini.');
        }

        $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        FundRequestApproval::create([
            'fund_request_id' => $fundRequest->id,
            'member_id' => $user->id,
            'status' => 'rejected',
            'reason' => $request->reason
        ]);

        // If one rejects, the whole request is rejected as per existing logic
        $fundRequest->update([
            'status' => 'rejected',
            'rejection_reason' => 'Ditolak oleh Ahli Jawatankuasa: ' . $user->name . '. Sebab: ' . $request->reason
        ]);

        // Notify Requester
        $fundRequest->requester->notify(new FundRequestProcessed($fundRequest, 'rejected'));

        return redirect()->route('dashboard')->with('success', 'Anda telah menolak permohonan ini.');
    }

    public function bossAction(Request $request, $id)
    {
        $user = Auth::user();
        if ($user->role !== 'boss') {
            abort(403);
        }

        $fundRequest = FundRequest::findOrFail($id);
        
        $action = $request->input('action'); // 'approve' or 'reject'

        if ($action === 'approve') {
            $fundRequest->update([
                'status' => 'approved_by_boss',
                'approval_reason' => $request->reason // Optional
            ]);
            $msg = 'Permohonan Dana Diluluskan.';
            
            // Notify Requester
            $fundRequest->requester->notify(new FundRequestProcessed($fundRequest, 'approved_by_boss'));
        } else {
            $request->validate([
                'reason' => 'required|string|max:500',
            ]);
            $fundRequest->update([
                'status' => 'rejected',
                'rejection_reason' => 'Ditolak oleh Pengerusi. Sebab: ' . $request->reason
            ]);
            $msg = 'Permohonan Dana Ditolak.';
            
            // Notify Requester
            $fundRequest->requester->notify(new FundRequestProcessed($fundRequest, 'rejected'));
        }

        return redirect()->route('dashboard')->with('success', $msg);
    }
}
