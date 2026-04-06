<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index()
    {
        $pendingUsers = User::where('is_approved', false)->where('role', '!=', 'admin')->get();
        $approvedUsers = User::where('is_approved', true)->where('role', '!=', 'admin')->get();
        
        return view('admin.users.index', compact('pendingUsers', 'approvedUsers'));
    }

    public function approve($id)
    {
        $user = User::findOrFail($id);
        $user->update(['is_approved' => true]);

        return back()->with('success', "Akaun {$user->name} telah diluluskan.");
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return back()->with('success', "Akaun {$user->name} telah dipadam.");
    }
}
