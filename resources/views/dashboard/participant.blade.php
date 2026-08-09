@extends('layouts.app')
@section('title', 'My Dashboard')

@section('content')
<x-ui.page-header title="My dashboard" subtitle="Track your registrations, certificates and upcoming events.">
    <a href="{{ route('home') }}" class="btn btn-primary">
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
        </svg>
        Browse events
    </a>
</x-ui.page-header>

<div class="grid gap-5 sm:grid-cols-3">
    <x-ui.stat label="Upcoming events" :value="$upcoming->count()" tone="primary"
        icon="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
    <x-ui.stat label="Total registrations" :value="$registrations->count()" tone="indigo"
        icon="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
    <x-ui.stat label="Certificates earned" :value="$registrations->where('certificate_generated', true)->count()" tone="emerald"
        icon="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 01-.982-3.172M9.497 14.25a7.454 7.454 0 00.981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 007.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M7.73 9.728a6.726 6.726 0 002.748 1.35m8.272-6.842V4.5c0 2.108-.966 3.99-2.48 5.228m2.48-5.492a46.32 46.32 0 012.916.52 6.003 6.003 0 01-5.395 4.972m0 0a6.726 6.726 0 01-2.749 1.35m0 0a6.772 6.772 0 01-3.044 0" />
</div>

<div class="mt-8 grid gap-6 lg:grid-cols-2">
    <div class="card p-6">
        <div class="flex items-center justify-between">
            <h2 class="text-base font-bold text-slate-900">Upcoming events</h2>
            <a href="{{ route('home') }}" class="text-sm font-semibold text-primary-700 hover:underline">Browse all</a>
        </div>
        <ul class="mt-4 divide-y divide-slate-100">
            @forelse ($upcoming as $reg)
                <li class="py-3">
                    <a href="{{ route('events.show', $reg->event) }}" class="text-sm font-semibold text-slate-900 hover:text-primary-700">{{ $reg->event->title }}</a>
                    <p class="mt-0.5 text-xs text-slate-500">
                        {{ \Carbon\Carbon::parse($reg->event->date)->format('l, d M Y') }} · {{ $reg->event->venue }}
                    </p>
                </li>
            @empty
                <li class="py-6 text-center text-sm text-slate-500">
                    No upcoming registrations.
                    <a href="{{ route('home') }}" class="font-semibold text-primary-700 hover:underline">Find events →</a>
                </li>
            @endforelse
        </ul>
    </div>

    <div class="card p-6">
        <h2 class="text-base font-bold text-slate-900">Registration history</h2>
        <ul class="mt-4 divide-y divide-slate-100">
            @forelse ($registrations as $reg)
                <li class="flex flex-wrap items-center justify-between gap-3 py-3">
                    <div class="min-w-0">
                        <p class="truncate text-sm font-semibold text-slate-900">{{ $reg->event->title ?? 'Deleted event' }}</p>
                        <p class="mt-0.5 text-xs text-slate-500">{{ \Carbon\Carbon::parse($reg->event->date ?? now())->format('d M Y') }}</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <x-ui.badge type="{{ $reg->status === 'attended' ? 'success' : ($reg->status === 'cancelled' ? 'danger' : 'info') }}">{{ ucfirst($reg->status) }}</x-ui.badge>
                        <div class="flex gap-1.5">
                            @if ($reg->status === 'registered')
                                <a href="{{ route('registrations.attendance-slip', $reg) }}" class="btn btn-secondary btn-sm">Attendance slip</a>
                            @endif
                            @if ($reg->status === 'attended')
                                @if (!$reg->questionnaire_completed)
                                    <a href="{{ route('registrations.questionnaire.show', $reg) }}" class="btn btn-secondary btn-sm">Feedback</a>
                                @endif
                                <a href="{{ route('certificates.generate', $reg) }}" class="btn btn-primary btn-sm">Certificate</a>
                            @endif
                        </div>
                    </div>
                </li>
            @empty
                <li class="py-6 text-center text-sm text-slate-500">You have not registered for any events yet.</li>
            @endforelse
        </ul>
    </div>
</div>
@endsection
