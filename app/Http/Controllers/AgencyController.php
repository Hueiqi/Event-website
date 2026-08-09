<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgencyController extends Controller
{
    // System Admin: manage all agencies
    public function index()
    {
        $agencies = Agency::withCount('users', 'events')->paginate(15);
        return view('agencies.index', compact('agencies'));
    }

    public function create()
    {
        return view('agencies.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateAgency($request);
        Agency::create($validated);

        return redirect()->route('agencies.index')->with('success', 'Agency registered successfully.');
    }

    public function edit(?Agency $agency = null)
    {
        $agency = $agency ?? Agency::findOrFail(Auth::user()->agency_id);
        return view('agencies.edit', compact('agency'));
    }

    public function update(Request $request, ?Agency $agency = null)
    {
        $agency = $agency ?? Agency::findOrFail(Auth::user()->agency_id);
        $validated = $this->validateAgency($request, $agency->agency_id);
        $agency->update($validated);

        return back()->with('success', 'Agency profile updated.');
    }

    public function destroy(Agency $agency)
    {
        $agency->delete();
        return redirect()->route('agencies.index')->with('success', 'Agency removed.');
    }

    public function reports()
    {
        $agency = Agency::withCount('events')->findOrFail(Auth::user()->agency_id);
        $events = $agency->events()->withCount('registrations')->latest()->paginate(15);

        return view('agencies.reports', compact('agency', 'events'));
    }

    private function validateAgency(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'agency_name' => ['required', 'string', 'max:200'],
            'agency_code' => ['required', 'string', 'max:50', 'unique:agencies,agency_code,' . $ignoreId . ',agency_id'],
            'address' => ['nullable', 'string'],
            'contact' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:100'],
        ]);
    }
}
