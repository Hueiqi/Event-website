<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // System Admin: manage all users / Agency Admin: manage organizers
    public function index()
    {
        $user = Auth::user();
        $users = $user->isAdmin()
            ? User::with('agency')->latest()->paginate(20)
            : User::where('agency_id', $user->agency_id)->where('role', 'organizer')->paginate(20);

        return view('users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:8'],
            'role' => ['required', 'in:admin,agency_admin,organizer,participant'],
            'user_type' => ['required', 'in:government,educational,private,politician,international,public'],
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['agency_id'] = Auth::user()->isAdmin() ? $request->agency_id : Auth::user()->agency_id;

        User::create($validated);

        return back()->with('success', 'User account created.');
    }

    public function edit()
    {
        return view('users.profile', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'unique:users,email,' . $user->user_id . ',user_id'],
            'mykad' => ['nullable', 'string', 'max:50'],
        ]);

        $user->update($validated);

        return back()->with('success', 'Profile updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success', 'User account removed.');
    }
}
