<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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
        $user = Auth::user();

        $stats = [
            'registrations' => $user->registrations()->count(),
            'upcoming' => $user->registrations()
                ->where('status', '!=', 'cancelled')
                ->whereHas('event', fn ($q) => $q->where('date', '>=', now()->toDateString()))
                ->count(),
            'attended' => $user->registrations()->where('status', 'attended')->count(),
            'certificates' => $user->registrations()->where('certificate_generated', true)->count(),
        ];

        $activities = collect();

        foreach ($user->registrations()->with('event')->latest()->get() as $registration) {
            $activities->push([
                'type' => 'registration',
                'title' => $registration->event?->title ?? 'Deleted event',
                'detail' => 'Registration ' . $registration->status,
                'time' => $registration->updated_at ?? $registration->created_at,
            ]);
        }

        foreach ($user->organizedEvents()->latest()->get() as $event) {
            $activities->push([
                'type' => 'event',
                'title' => $event->title,
                'detail' => 'Event ' . $event->status,
                'time' => $event->created_at,
            ]);
        }

        $activities = $activities->sortByDesc('time')->take(8)->values();

        return view('users.profile', compact('user', 'stats', 'activities'));
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

    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $user = Auth::user();

        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->update(['avatar' => $request->file('avatar')->store('avatars', 'public')]);

        return back()->with('success', 'Profile photo updated.');
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if (! Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Your current password is incorrect.']);
        }

        $user->update(['password' => Hash::make($request->password)]);

        return back()->with('success', 'Password updated successfully.');
    }

    public function updateNotifications(Request $request)
    {
        $request->validate([
            'preferences' => ['nullable', 'array'],
            'preferences.*' => ['in:upcoming_events,event_updates,news_updates'],
        ]);

        Auth::user()->update([
            'notification_preferences' => array_values($request->input('preferences', [])),
        ]);

        return back()->with('success', 'Notification preferences updated.');
    }

    public function destroyAccount(Request $request)
    {
        $user = Auth::user();

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $user->delete();

        return redirect('/')->with('success', 'Your account has been deleted. We are sorry to see you go.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success', 'User account removed.');
    }
}
