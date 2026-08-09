@extends('layouts.app')
@section('title', 'My Dashboard')

@section('content')
{{-- Welcome hero --}}
<div class="relative mb-6 overflow-hidden rounded-2xl bg-gradient-to-r from-primary-800 via-primary-900 to-primary-950 px-6 py-4 text-white shadow-sm sm:px-8 sm:py-5">
    <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <p class="text-sm font-medium text-primary-200">Welcome back,</p>
            <h1 class="mt-1 text-2xl font-bold tracking-tight sm:text-3xl">{{ $user->name }}</h1>
            <p class="mt-2 flex items-center gap-1.5 text-sm text-primary-200">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                </svg>
                {{ now()->format('l, j F Y') }} · {{ now()->format('h:i A') }}
            </p>
        </div>
        <a href="{{ route('home') }}" class="btn bg-white text-primary-800 shadow-sm hover:bg-primary-50">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
            </svg>
            Browse events
        </a>
    </div>
</div>

{{-- Quick actions --}}
<div class="mb-8 grid gap-4 sm:grid-cols-3">
    <a href="{{ route('home') }}" class="card group flex items-center gap-4 p-4 transition duration-200 hover:-translate-y-0.5 hover:border-primary-300 hover:shadow-md">
        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-primary-50 text-primary-700 transition duration-200 group-hover:bg-primary-100">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
            </svg>
        </span>
        <span class="min-w-0 flex-1">
            <span class="block text-sm font-semibold text-slate-900">Browse events</span>
            <span class="block text-xs text-slate-600">Discover and register</span>
        </span>
        <svg class="h-4 w-4 shrink-0 text-slate-500 transition duration-200 group-hover:translate-x-0.5 group-hover:text-primary-600" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
        </svg>
    </a>

    <a href="#history" class="card group flex items-center gap-4 p-4 transition duration-200 hover:-translate-y-0.5 hover:border-primary-300 hover:shadow-md">
        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-indigo-50 text-indigo-700 transition duration-200 group-hover:bg-indigo-100">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
        </span>
        <span class="min-w-0 flex-1">
            <span class="block text-sm font-semibold text-slate-900">My registrations</span>
            <span class="block text-xs text-slate-600">Slips, QR and certificates</span>
        </span>
        <svg class="h-4 w-4 shrink-0 text-slate-500 transition duration-200 group-hover:translate-x-0.5 group-hover:text-primary-600" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
        </svg>
    </a>

    <a href="{{ route('profile.edit') }}" class="card group flex items-center gap-4 p-4 transition duration-200 hover:-translate-y-0.5 hover:border-primary-300 hover:shadow-md">
        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700 transition duration-200 group-hover:bg-emerald-100">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
            </svg>
        </span>
        <span class="min-w-0 flex-1">
            <span class="block text-sm font-semibold text-slate-900">My profile</span>
            <span class="block text-xs text-slate-600">Update your details</span>
        </span>
        <svg class="h-4 w-4 shrink-0 text-slate-500 transition duration-200 group-hover:translate-x-0.5 group-hover:text-primary-600" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
        </svg>
    </a>
</div>

{{-- Stats --}}
@php
    $nextEvent = $upcoming->first();
@endphp
<div class="grid gap-5 sm:grid-cols-3">
    <x-ui.stat label="Upcoming events" :value="$upcoming->count()" tone="primary"
        detail="{{ $nextEvent ? 'Next: ' . \Carbon\Carbon::parse($nextEvent->event->date)->format('d M Y') : 'No upcoming events' }}"
        icon="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
    <x-ui.stat label="Total registrations" :value="$registrations->count()" tone="indigo"
        detail="{{ $attendedCount ? $attendedCount . ' attended' : 'No attendance yet' }}"
        icon="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
    <x-ui.stat label="Certificates earned" :value="$certificateCount" tone="emerald"
        detail="{{ $certificateCount ? 'Ready to download' : 'Attend an event to earn one' }}"
        icon="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 01-.982-3.172M9.497 14.25a7.454 7.454 0 00.981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 007.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M7.73 9.728a6.726 6.726 0 002.748 1.35m8.272-6.842V4.5c0 2.108-.966 3.99-2.48 5.228m2.48-5.492a46.32 46.32 0 012.916.52 6.003 6.003 0 01-5.395 4.972m0 0a6.726 6.726 0 01-2.749 1.35m0 0a6.772 6.772 0 01-3.044 0" />
</div>

{{-- Upcoming events --}}
<div id="upcoming" class="card mt-8 overflow-hidden">
    <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4 sm:px-6">
        <div>
            <h2 class="text-base font-bold text-slate-900">Upcoming events</h2>
            <p class="text-xs text-slate-600">Events you are registered for</p>
        </div>
        <a href="{{ route('home') }}" class="text-sm font-semibold text-primary-700 hover:underline">Browse all</a>
    </div>

    <ul class="divide-y divide-slate-100">
        @forelse ($upcoming as $reg)
            @php
                $eventDate = \Carbon\Carbon::parse($reg->event->date);
                $daysUntil = now()->startOfDay()->diffInDays($eventDate->copy()->startOfDay(), false);
                $filled = $reg->event->registrations_count ?? 0;
                $capacity = $reg->event->capacity ?: 0;
                $percent = $capacity ? min(100, round($filled / $capacity * 100)) : 0;
            @endphp
            <li class="flex flex-col gap-4 px-5 py-5 transition hover:bg-slate-50 sm:px-6 lg:flex-row lg:items-center">
                <div class="flex min-w-0 flex-1 items-center gap-4">
                    <div class="flex h-14 w-14 shrink-0 flex-col items-center justify-center rounded-xl bg-primary-50 text-primary-800">
                        <span class="text-base font-bold leading-none">{{ $eventDate->format('d') }}</span>
                        <span class="mt-0.5 text-[10px] font-semibold uppercase tracking-wide">{{ $eventDate->format('M') }}</span>
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="flex flex-wrap items-center gap-2">
                            <a href="{{ route('events.show', $reg->event) }}" class="truncate text-sm font-semibold text-slate-900 hover:text-primary-700">{{ $reg->event->title }}</a>
                            <x-ui.badge type="{{ $daysUntil === 0 ? 'warning' : 'info' }}">
                                @if ($daysUntil === 0)
                                    Today
                                @elseif ($daysUntil === 1)
                                    Tomorrow
                                @else
                                    in {{ $daysUntil }} days
                                @endif
                            </x-ui.badge>
                            <x-ui.badge type="{{ $reg->event->status === 'open' ? 'success' : 'neutral' }}">{{ ucfirst($reg->event->status) }}</x-ui.badge>
                        </div>
                        <p class="mt-1 text-xs text-slate-600">
                            {{ $eventDate->format('l, d M Y') }} · {{ $reg->event->time }} · {{ $reg->event->venue }}
                        </p>
                        <div class="mt-2.5 flex items-center gap-3">
                            <div class="h-3 w-full max-w-xs overflow-hidden rounded-full bg-slate-200">
                                <div class="h-full rounded-full bg-primary-600" style="width: {{ $percent }}%"></div>
                            </div>
                            <span class="shrink-0 text-xs font-semibold text-slate-600">{{ $filled }}/{{ $capacity }} registered</span>
                        </div>
                    </div>
                </div>
                <div class="flex shrink-0 items-center gap-2 lg:pl-4">
                    <a href="{{ route('events.show', $reg->event) }}" class="btn btn-primary btn-sm">Details</a>
                    <a href="{{ route('registrations.attendance-slip', $reg) }}" class="btn btn-secondary btn-sm">
                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0113.5 9.375v-4.5zM13.5 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5z" />
                        </svg>
                        QR slip
                    </a>
                </div>
            </li>
        @empty
            <li class="px-6 py-10 text-center">
                <p class="text-sm text-slate-500">No upcoming registrations.</p>
                <a href="{{ route('home') }}" class="mt-2 inline-block text-sm font-semibold text-primary-700 hover:underline">Find events →</a>
            </li>
        @endforelse
    </ul>
</div>

{{-- Registration history --}}
<div id="history" class="card mt-8 overflow-hidden">
    <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4 sm:px-6">
        <div>
            <h2 class="text-base font-bold text-slate-900">Registration history</h2>
            <p class="text-xs text-slate-600">Slips, QR codes and certificates</p>
        </div>
        <span class="text-sm font-medium text-slate-500">{{ $registrations->count() }} total</span>
    </div>

    <ul class="divide-y divide-slate-100">
        @forelse ($registrations as $reg)
            <li class="flex flex-col gap-4 px-5 py-5 transition hover:bg-slate-50 sm:px-6 lg:flex-row lg:items-center">
                <div class="min-w-0 flex-1">
                    <div class="flex flex-wrap items-center gap-2">
                        <a href="{{ route('events.show', $reg->event) }}" class="truncate text-sm font-semibold text-slate-900 hover:text-primary-700">{{ $reg->event->title ?? 'Deleted event' }}</a>
                        <x-ui.badge type="{{ $reg->status === 'attended' ? 'success' : ($reg->status === 'cancelled' ? 'danger' : 'info') }}">{{ ucfirst($reg->status) }}</x-ui.badge>
                    </div>
                    <p class="mt-0.5 text-xs text-slate-600">
                        {{ \Carbon\Carbon::parse($reg->event->date ?? now())->format('d M Y') }} · {{ $reg->event->venue ?? '' }}
                    </p>
                    @if ($reg->qr_code)
                        <p class="mt-1 font-mono text-[11px] text-slate-500">Ref: {{ str($reg->qr_code)->limit(18) }}</p>
                    @endif
                </div>
                <div class="flex shrink-0 flex-wrap items-center gap-2">
                    @if ($reg->status === 'registered')
                        <a href="{{ route('registrations.attendance-slip', $reg) }}" class="btn btn-primary btn-sm">Attendance slip</a>
                        <a href="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data={{ urlencode($reg->qr_code) }}" target="_blank" rel="noopener noreferrer" class="btn btn-secondary btn-sm" title="Download QR code">
                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0113.5 9.375v-4.5zM13.5 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5z" />
                            </svg>
                            QR
                        </a>
                        @if ($reg->event && $reg->event->date->startOfDay()->gte(now()->startOfDay()))
                            <form method="POST" action="{{ route('registrations.destroy', $reg) }}" onsubmit="return confirm('Cancel your registration for this event? This cannot be undone.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm bg-white text-rose-700 ring-1 ring-inset ring-rose-300 hover:bg-rose-50">Cancel</button>
                            </form>
                        @endif
                    @endif
                    @if ($reg->status === 'attended')
                        @if (!$reg->questionnaire_completed)
                            <a href="{{ route('registrations.questionnaire.show', $reg) }}" class="btn btn-secondary btn-sm">Feedback</a>
                        @endif
                        <a href="{{ route('certificates.generate', $reg) }}" class="btn btn-primary btn-sm">Certificate</a>
                    @endif
                </div>
            </li>
        @empty
            <li class="px-6 py-10 text-center">
                <p class="text-sm text-slate-500">You have not registered for any events yet.</p>
                <a href="{{ route('home') }}" class="mt-2 inline-block text-sm font-semibold text-primary-700 hover:underline">Browse events →</a>
            </li>
        @endforelse
    </ul>
</div>
@endsection
