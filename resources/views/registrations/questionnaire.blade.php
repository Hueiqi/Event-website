@extends('layouts.app')
@section('title', 'Event Feedback')

@section('content')
<div class="mx-auto max-w-xl">
    <div class="card overflow-hidden">
        <div class="bg-gradient-to-br from-emerald-600 to-emerald-800 px-6 py-7 sm:px-8">
            <h1 class="text-xl font-bold text-white">Event feedback</h1>
            <p class="mt-1 text-sm text-emerald-100">Your feedback helps improve future government programs.</p>
        </div>

        <form method="POST" action="{{ route('registrations.questionnaire', $registration) }}" class="space-y-5 p-6 sm:p-8">
            @csrf

            <div>
                <label class="label" for="satisfaction">Overall satisfaction</label>
                <select id="satisfaction" name="responses[satisfaction]" required class="input">
                    <option value="excellent">Excellent</option>
                    <option value="good">Good</option>
                    <option value="fair">Fair</option>
                    <option value="poor">Poor</option>
                </select>
            </div>

            <div>
                <label class="label" for="organization">Was the venue and organization satisfactory?</label>
                <select id="organization" name="responses[organization]" required class="input">
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
            </div>

            <div>
                <label class="label" for="comments">Additional comments</label>
                <textarea id="comments" name="responses[comments]" rows="3" placeholder="Share your thoughts..." class="input"></textarea>
            </div>

            <div class="flex gap-3 border-t border-slate-100 pt-5">
                <button type="submit" class="btn btn-primary">Submit feedback</button>
                <a href="{{ route('dashboard') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
