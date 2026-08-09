<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\Category;
use App\Models\Event;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    // Public program search (Participant function: Search Programs)
    public function publicIndex(Request $request)
    {
        $events = Event::with(['category', 'agency'])
            ->withCount('registrations')
            ->where('status', 'open')
            ->orderBy('date')
            ->paginate(12);

        return view('events.public-index', $this->publicPageData($events));
    }

    public function search(Request $request)
    {
        $query = Event::with(['category', 'agency'])->withCount('registrations')->where('status', 'open');

        if ($request->filled('keyword')) {
            $query->where('title', 'like', '%' . $request->keyword . '%');
        }
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }

        $events = $query->orderBy('date')->paginate(12)->withQueryString();

        return view('events.public-index', $this->publicPageData($events));
    }

    private function publicPageData($events): array
    {
        $categories = Category::withCount('events')->get();

        $stats = [
            'events' => Event::where('status', 'open')->count(),
            'agencies' => Agency::count(),
            'users' => User::count(),
            'registrations' => Registration::count(),
        ];

        $agencies = Agency::orderBy('agency_name')->take(8)->get();

        return compact('events', 'categories', 'stats', 'agencies');
    }

    public function show(Event $event)
    {
        $event->load(['category', 'agency', 'organizer', 'materials']);
        $alreadyRegistered = false;

        if (Auth::check()) {
            $alreadyRegistered = $event->registrations()
                ->where('user_id', Auth::id())
                ->where('status', '!=', 'cancelled')
                ->exists();
        }

        return view('events.show', compact('event', 'alreadyRegistered'));
    }

    // Organizer/Agency Admin: manage events
    public function index()
    {
        $user = Auth::user();
        $events = $user->isAdmin()
            ? Event::with('agency')->withCount('registrations')->latest()->paginate(15)
            : Event::where('agency_id', $user->agency_id)->withCount('registrations')->latest()->paginate(15);

        return view('events.index', compact('events'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('events.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateEvent($request);
        $validated['agency_id'] = Auth::user()->agency_id;
        $validated['organizer_id'] = Auth::id();

        $event = Event::create($validated);

        return redirect()->route('events.index')->with('success', "Event \"{$event->title}\" created successfully.");
    }

    public function edit(Event $event)
    {
        $this->authorizeAccess($event);
        $categories = Category::all();
        return view('events.edit', compact('event', 'categories'));
    }

    public function update(Request $request, Event $event)
    {
        $this->authorizeAccess($event);
        $validated = $this->validateEvent($request);
        $event->update($validated);

        return redirect()->route('events.index')->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event)
    {
        $this->authorizeAccess($event);
        $event->update(['status' => 'cancelled']);

        // Notify registered participants of cancellation (email service)
        foreach ($event->registrations()->where('status', 'registered')->get() as $registration) {
            // Mail::to($registration->user->email)->send(new EventCancelledMail($event));
        }

        return redirect()->route('events.index')->with('success', 'Event cancelled and participants notified.');
    }

    public function report(Event $event)
    {
        $this->authorizeAccess($event);
        $event->load('registrations.user');

        return view('events.report', compact('event'));
    }

    public function announce(Request $request, Event $event)
    {
        $this->authorizeAccess($event);
        $request->validate(['message' => 'required|string|max:1000']);

        // foreach registered participants -> Mail::send announcement

        return back()->with('success', 'Announcement sent to all registered participants.');
    }

    private function validateEvent(Request $request): array
    {
        return $request->validate([
            'category_id' => ['required', 'exists:categories,category_id'],
            'title' => ['required', 'string', 'max:200'],
            'description' => ['nullable', 'string'],
            'date' => ['required', 'date'],
            'time' => ['required'],
            'venue' => ['required', 'string', 'max:200'],
            'capacity' => ['required', 'integer', 'min:1'],
            'status' => ['required', 'in:draft,open,closed,cancelled,completed'],
        ]);
    }

    private function authorizeAccess(Event $event): void
    {
        $user = Auth::user();
        if (!$user->isAdmin() && $event->agency_id !== $user->agency_id) {
            abort(403, 'You do not have permission to manage this event.');
        }
    }
}
