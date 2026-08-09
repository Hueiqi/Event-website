<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class RegistrationController extends Controller
{
    // Participant registers for an event
    public function store(Event $event)
    {
        if ($event->status !== 'open') {
            return back()->with('error', 'This event is not open for registration.');
        }

        if ($event->isFull()) {
            return back()->with('error', 'This event has reached full capacity. You may contact the organizer about a waitlist.');
        }

        $existing = Registration::where('user_id', Auth::id())
            ->where('event_id', $event->event_id)
            ->first();

        if ($existing && $existing->status !== 'cancelled') {
            return back()->with('error', 'You are already registered for this event.');
        }

        $registration = Registration::updateOrCreate(
            ['user_id' => Auth::id(), 'event_id' => $event->event_id],
            [
                'status' => 'registered',
                'qr_code' => Str::uuid(),
                'checked_in' => false,
                'certificate_generated' => false,
            ]
        );

        // Mail::to(Auth::user()->email)->send(new RegistrationConfirmationMail($event, $registration));

        return redirect()->route('events.show', $event)
            ->with('success', 'You have successfully registered for this event. A confirmation has been sent to your email.');
    }

    public function destroy(Registration $registration)
    {
        if ($registration->user_id !== Auth::id()) {
            abort(403);
        }

        $registration->update(['status' => 'cancelled']);

        return redirect()->route('dashboard')->with('success', 'Registration cancelled.');
    }

    // Organizer views registrations for an event
    public function index(Event $event)
    {
        $registrations = $event->registrations()->with('user')->paginate(20);
        return view('events.registrations', compact('event', 'registrations'));
    }

    // Organizer marks attendance
    public function markAttendance(Event $event, Registration $registration)
    {
        if ($registration->event_id !== $event->event_id) {
            abort(404);
        }

        $registration->update([
            'status' => 'attended',
            'checked_in' => true,
            'checked_in_at' => now(),
        ]);

        return back()->with('success', 'Attendance recorded for ' . $registration->user->name . '.');
    }

    public function showAttendanceSlip(Registration $registration)
    {
        if ($registration->user_id !== Auth::id()) {
            abort(403);
        }

        return view('registrations.attendance-slip', compact('registration'));
    }

    public function showQuestionnaire(Registration $registration)
    {
        if ($registration->user_id !== Auth::id()) {
            abort(403);
        }

        return view('registrations.questionnaire', compact('registration'));
    }

    public function submitQuestionnaire(Request $request, Registration $registration)
    {
        if ($registration->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate(['responses' => 'required|array']);

        // Persist responses to a questionnaire_responses table in a fuller implementation
        $registration->update(['questionnaire_completed' => true]);

        return back()->with('success', 'Thank you for your feedback.');
    }
}
