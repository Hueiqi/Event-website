<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\PresentationMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MaterialController extends Controller
{
    public function store(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:200'],
            'file' => ['required', 'file', 'mimes:pdf,ppt,pptx,doc,docx', 'max:20480'],
        ]);

        $path = $request->file('file')->store('materials/' . $event->event_id, 'public');

        PresentationMaterial::create([
            'event_id' => $event->event_id,
            'title' => $validated['title'],
            'file_path' => $path,
            'uploaded_by' => Auth::id(),
        ]);

        return back()->with('success', 'Material uploaded successfully.');
    }

    public function download(PresentationMaterial $material)
    {
        $event = $material->event;
        $user = Auth::user();

        $isRegistered = $event->registrations()
            ->where('user_id', $user->user_id)
            ->where('status', '!=', 'cancelled')
            ->exists();

        if (!$isRegistered && $event->agency_id !== $user->agency_id && !$user->isAdmin()) {
            abort(403, 'You must be registered for this event to download materials.');
        }

        return Storage::disk('public')->download($material->file_path, $material->title);
    }

    public function destroy(PresentationMaterial $material)
    {
        Storage::disk('public')->delete($material->file_path);
        $material->delete();

        return back()->with('success', 'Material removed.');
    }
}
