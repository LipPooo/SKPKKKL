<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FundRequest;
use App\Models\ProgramReport;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $data = [];

        if ($user->role === 'boss') {
            // Boss sees everything
            $data['total_requests'] = FundRequest::count();
            $data['pending_boss'] = FundRequest::where('status', 'pending_boss')->count();
            $data['in_process'] = FundRequest::where('status', 'pending_members')->count();
            $data['approved'] = FundRequest::where('status', 'approved_by_boss')->count();
            
            $data['recent_requests'] = FundRequest::with(['requester', 'programReport'])
                ->latest()
                ->take(5)
                ->get();
        } else {
            // Member sees their own and what they need to support
            $data['total_requests'] = FundRequest::where('requester_id', $user->id)->count();
            
            // Pending support: requests by others that this member hasn't approved yet
            // For now, let's just show all pending_members as "need support"
            $data['pending_support'] = FundRequest::where('status', 'pending_members')
                ->where('requester_id', '!=', $user->id)
                ->count();
                
            $data['my_pending'] = FundRequest::where('requester_id', $user->id)
                ->whereIn('status', ['pending_members', 'pending_boss'])
                ->count();
                
            $data['my_approved'] = FundRequest::where('requester_id', $user->id)
                ->where('status', 'approved_by_boss')
                ->count();

            $data['recent_requests'] = FundRequest::with(['requester', 'programReport'])
                ->where('requester_id', $user->id)
                ->latest()
                ->take(5)
                ->get();
        }

        return view('dashboard', compact('data', 'user'));
    }

    public function markNotificationsAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return back()->with('success', 'Semua notifikasi ditandakan sebagai dibaca.');
    }

    public function markNotificationAsRead($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        if (isset($notification->data['url'])) {
            return redirect($notification->data['url']);
        }

        return back();
    }
}
