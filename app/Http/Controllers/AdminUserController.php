<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'employee_id' => 'required|string|max:255|unique:users,employee_id,' . $user->id,
            'role' => 'required|in:member,boss',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'employee_id' => $request->employee_id,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', "Akaun {$user->name} telah dikemaskini.");
    }

    public function bulkApprove(Request $request)
    {
        $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
        ]);

        $count = User::whereIn('id', $request->user_ids)->update(['is_approved' => true]);

        return back()->with('success', "Sebanyak {$count} akaun telah diluluskan.");
    }

    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
        ]);

        // Prevents admin from deleting themselves accidentally
        $userIds = array_diff($request->user_ids, [auth()->id()]);
        
        $count = count($userIds);
        if ($count > 0) {
            User::whereIn('id', $userIds)->delete();
        }

        return back()->with('success', "Sebanyak {$count} akaun telah dipadam.");
    }
}
