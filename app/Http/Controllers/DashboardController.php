<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\Event;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return match ($user->role) {
            'admin' => $this->adminDashboard(),
            'agency_admin' => $this->agencyDashboard($user),
            'organizer' => $this->organizerDashboard($user),
            default => $this->participantDashboard($user),
        };
    }

    private function adminDashboard()
    {
        $stats = [
            'agencies' => Agency::count(),
            'users' => User::count(),
            'events' => Event::count(),
            'registrations' => Registration::count(),
        ];

        return view('dashboard.admin', compact('stats'));
    }

    private function agencyDashboard(User $user)
    {
        $events = Event::where('agency_id', $user->agency_id)->latest()->take(10)->get();
        $organizers = User::where('agency_id', $user->agency_id)->where('role', 'organizer')->get();

        return view('dashboard.agency-admin', compact('events', 'organizers'));
    }

    private function organizerDashboard(User $user)
    {
        $events = $user->organizedEvents()->withCount('registrations')->latest()->get();
        return view('dashboard.organizer', compact('events'));
    }

    private function participantDashboard(User $user)
    {
        $registrations = $user->registrations()
            ->with(['event' => fn ($q) => $q->withCount([
                'registrations' => fn ($q) => $q->where('status', '!=', 'cancelled'),
            ])])
            ->latest()
            ->get();

        $upcoming = $registrations
            ->where('status', '!=', 'cancelled')
            ->filter(fn ($r) => $r->event && $r->event->date->startOfDay()->gte(now()->startOfDay()))
            ->sortBy(fn ($r) => $r->event->date)
            ->values();

        $certificateCount = $registrations->where('certificate_generated', true)->count();
        $attendedCount = $registrations->where('status', 'attended')->count();

        return view('dashboard.participant', compact('user', 'registrations', 'upcoming', 'certificateCount', 'attendedCount'));
    }

    public function systemReports()
    {
        $events = Event::withCount('registrations')->latest()->paginate(20);
        return view('admin.reports', compact('events'));
    }

    public function activityLog()
    {
        // In a full build, pull from an activity_log table
        return view('admin.activity');
    }
}
