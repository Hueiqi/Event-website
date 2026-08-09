@extends('layouts.app')
@section('title', $event->title)

@section('content')
<div class="grid gap-6 lg:grid-cols-3">
    {{-- Main content --}}
    <div class="lg:col-span-2">
        <div class="card p-6 sm:p-8">
            <div class="flex flex-wrap items-center gap-2">
                <x-ui.badge type="{{ $event->status === 'open' ? 'success' : 'neutral' }}">{{ ucfirst($event->status) }}</x-ui.badge>
                <x-ui.badge type="info">{{ $event->category->category_name ?? 'General' }}</x-ui.badge>
            </div>

            <h1 class="mt-4 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">{{ $event->title }}</h1>
            <p class="mt-2 flex items-center gap-2 text-slate-500">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                </svg>
                Organized by {{ $event->agency->agency_name ?? 'N/A' }}
            </p>

            <div class="mt-6 space-y-4 border-t border-slate-100 pt-6">
                <div class="flex gap-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-primary-50 text-primary-700">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-slate-900">Date & time</p>
                        <p class="text-sm text-slate-600">{{ \Carbon\Carbon::parse($event->date)->format('l, d F Y') }} · {{ $event->time }}</p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-primary-50 text-primary-700">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-slate-900">Venue</p>
                        <p class="text-sm text-slate-600">{{ $event->venue }}</p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-primary-50 text-primary-700">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-slate-900">Capacity</p>
                        <p class="text-sm text-slate-600">{{ $event->registrations->count() }} of {{ $event->capacity }} seats filled</p>
                    </div>
                </div>
            </div>
        </div>

        @if ($event->description)
            <div class="card mt-6 p-6 sm:p-8">
                <h2 class="text-lg font-bold text-slate-900">About this event</h2>
                <p class="mt-3 whitespace-pre-line leading-relaxed text-slate-600">{{ $event->description }}</p>
            </div>
        @endif

        @if ($event->materials->isNotEmpty())
            <div class="card mt-6 p-6 sm:p-8">
                <h2 class="text-lg font-bold text-slate-900">Presentation materials</h2>
                <ul class="mt-4 divide-y divide-slate-100">
                    @foreach ($event->materials as $material)
                        <li class="flex items-center justify-between py-3">
                            <span class="flex items-center gap-3 text-sm text-slate-700">
                                <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                </svg>
                                {{ $material->title }}
                            </span>
                            <a href="{{ route('materials.download', $material) }}" class="btn btn-secondary btn-sm">Download</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    {{-- Sidebar / registration --}}
    <aside>
        <div class="card sticky top-24 p-6">
            <h2 class="text-base font-bold text-slate-900">Registration</h2>

            @guest
                <p class="mt-3 text-sm text-slate-600">Sign in to register for this event.</p>
                <a href="{{ route('login') }}" class="btn btn-primary mt-4 w-full">Login to register</a>
                <p class="mt-3 text-center text-xs text-slate-400">
                    No account? <a href="{{ route('register') }}" class="font-semibold text-primary-700 hover:underline">Create one</a>
                </p>
            @endguest

            @auth
                @if (!auth()->user()->isParticipant())
                    <p class="mt-3 text-sm text-slate-600">
                        You are signed in as {{ ucfirst(str_replace('_', ' ', auth()->user()->role)) }}. Participant accounts can register for events.
                    </p>
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary mt-4 w-full">Go to dashboard</a>
                @else
                    @if ($alreadyRegistered)
                        <div class="mt-4 rounded-xl bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-200">
                            ✓ You are registered for this event
                        </div>
                        <a href="{{ route('dashboard') }}" class="btn btn-secondary mt-4 w-full">View my registrations</a>
                    @elseif ($event->isFull())
                        <div class="mt-4 rounded-xl bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-700 ring-1 ring-inset ring-rose-200">
                            This event is currently full
                        </div>
                    @else
                        <p class="mt-3 text-sm text-slate-600">Secure your spot for this event. Registration is free.</p>
                        <form method="POST" action="{{ route('registrations.store', $event) }}" class="mt-4">
                            @csrf
                            <button type="submit" class="btn btn-primary w-full">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 010 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 010-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375z" />
                                </svg>
                                Register now
                            </button>
                        </form>
                    @endif
                @endif
            @endauth
        </div>
    </aside>
</div>
@endsection
