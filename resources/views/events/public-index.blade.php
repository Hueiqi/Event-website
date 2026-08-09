@extends('layouts.app')
@section('title', 'Browse Events')

@php
    // Category -> icon + gradient + soft chip styling
    $categoryStyles = [
        'training'    => ['icon' => 'M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5', 'grad' => 'from-indigo-500 to-blue-600', 'chip' => 'bg-indigo-50 text-indigo-700 ring-indigo-200', 'head' => 'from-indigo-500 to-blue-700'],
        'conference'  => ['icon' => 'M12 18.75a6 6 0 006-6v-1.5m-6 7.5a6 6 0 01-6-6v-1.5m6 7.5v3.75m-3.75 0h7.5M12 15.75a3 3 0 01-3-3V4.5a3 3 0 116 0v8.25a3 3 0 01-3 3z', 'grad' => 'from-primary-500 to-primary-700', 'chip' => 'bg-primary-50 text-primary-700 ring-primary-200', 'head' => 'from-primary-600 to-primary-800'],
        'meeting'     => ['icon' => 'M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z', 'grad' => 'from-emerald-500 to-teal-600', 'chip' => 'bg-emerald-50 text-emerald-700 ring-emerald-200', 'head' => 'from-emerald-500 to-teal-700'],
        'course'      => ['icon' => 'M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25', 'grad' => 'from-amber-500 to-orange-600', 'chip' => 'bg-amber-50 text-amber-700 ring-amber-200', 'head' => 'from-amber-500 to-orange-700'],
        'event'       => ['icon' => 'M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5', 'grad' => 'from-rose-500 to-pink-600', 'chip' => 'bg-rose-50 text-rose-700 ring-rose-200', 'head' => 'from-rose-500 to-pink-700'],
    ];

    // Event status -> badge tone + icon
    $statusMeta = [
        'open'      => ['tone' => 'success', 'icon' => 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
        'closed'    => ['tone' => 'neutral', 'icon' => 'M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z'],
        'draft'     => ['tone' => 'neutral', 'icon' => 'M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z'],
        'cancelled' => ['tone' => 'danger', 'icon' => 'M6 18L18 6M6 6l12 12'],
        'completed' => ['tone' => 'success', 'icon' => 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
    ];

    function category_style($name, $map)
    {
        $key = strtolower(trim($name ?? ''));
        foreach ($map as $match => $style) {
            if ($key === $match || str_contains($key, $match)) {
                return $style;
            }
        }
        return ['icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'grad' => 'from-slate-500 to-slate-700', 'chip' => 'bg-slate-100 text-slate-600 ring-slate-200', 'head' => 'from-slate-600 to-slate-800'];
    }
@endphp

@section('content')
{{-- ================= HERO ================= --}}
<section class="relative -mx-4 -mt-8 overflow-hidden bg-gradient-to-br from-primary-950 via-primary-900 to-primary-800 sm:-mx-6 lg:-mx-8">
    {{-- Decorative layers --}}
    <div class="pointer-events-none absolute inset-0">
        <div class="absolute inset-0 opacity-25" style="background-image: radial-gradient(circle at 15% 25%, rgba(255,255,255,0.4) 0, transparent 40%), radial-gradient(circle at 85% 15%, rgba(255,255,255,0.3) 0, transparent 35%), radial-gradient(circle at 55% 90%, rgba(255,255,255,0.22) 0, transparent 45%);"></div>
        <div class="absolute -right-24 -top-24 h-96 w-96 rounded-full bg-white/5 blur-3xl"></div>
        <div class="absolute -bottom-32 left-1/4 h-80 w-80 rounded-full bg-primary-500/20 blur-3xl"></div>
    </div>

    <div class="relative mx-auto max-w-7xl px-4 pb-28 pt-16 sm:px-6 sm:pt-24 lg:px-8">
        <div class="max-w-2xl">
            <span class="inline-flex items-center gap-2 rounded-full bg-white/10 px-3 py-1 text-xs font-semibold text-primary-100 ring-1 ring-inset ring-white/20 backdrop-blur">
                <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                Official Malaysian Government Events Platform
            </span>

            <h1 class="mt-5 text-3xl font-bold leading-tight tracking-tight text-white sm:text-4xl lg:text-5xl">
                Discover government programs,
                <span class="bg-gradient-to-r from-primary-300 to-white bg-clip-text text-transparent">training & events</span>
            </h1>

            <p class="mt-5 max-w-xl text-base leading-relaxed text-primary-100/90">
                One platform to search and register for events organised by Malaysian government agencies — conferences, training, courses and public programmes.
            </p>

            <div class="mt-8 flex flex-wrap items-center gap-3">
                <a href="#events" class="btn bg-white px-6 text-primary-800 shadow-lg shadow-primary-950/20 hover:bg-primary-50">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                    Browse events
                </a>
                @auth
                    <a href="{{ route('dashboard') }}" class="btn bg-white/10 px-6 text-white ring-1 ring-inset ring-white/25 backdrop-blur hover:bg-white/20">Go to dashboard</a>
                @else
                    <a href="{{ route('register') }}" class="btn bg-white/10 px-6 text-white ring-1 ring-inset ring-white/25 backdrop-blur hover:bg-white/20">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM3 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 019.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
                        </svg>
                        Create account
                    </a>
                @endauth
            </div>

            <div class="mt-8 flex flex-wrap items-center gap-x-6 gap-y-2 text-xs text-primary-200/80">
                <span class="flex items-center gap-1.5">
                    <svg class="h-4 w-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Free registration
                </span>
                <span class="flex items-center gap-1.5">
                    <svg class="h-4 w-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 01-.982-3.172M9.497 14.25a7.454 7.454 0 00.981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 007.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M7.73 9.728a6.726 6.726 0 002.748 1.35m8.272-6.842V4.5c0 2.108-.966 3.99-2.48 5.228m2.48-5.492a46.32 46.32 0 012.916.52 6.003 6.003 0 01-5.395 4.972m0 0a6.726 6.726 0 01-2.749 1.35m0 0a6.772 6.772 0 01-3.044 0" />
                    </svg>
                    E-certificates
                </span>
                <span class="flex items-center gap-1.5">
                    <svg class="h-4 w-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Real-time availability
                </span>
            </div>
        </div>
    </div>
</section>

{{-- ================= STATS ================= --}}
<section class="relative z-10 mx-auto -mt-16 max-w-7xl px-4 sm:px-6 lg:px-8" data-reveal>
    <div class="grid grid-cols-2 gap-px overflow-hidden rounded-2xl border border-slate-200 bg-slate-200 shadow-xl shadow-slate-900/5 lg:grid-cols-4">
        <div class="bg-white p-5 text-center sm:p-6">
            <p class="text-2xl font-bold tracking-tight text-primary-700 sm:text-3xl" data-count="{{ $stats['events'] }}">0</p>
            <p class="mt-1 text-xs font-medium uppercase tracking-wide text-slate-500 sm:text-sm">{{ $stats['events'] === 1 ? 'Open event' : 'Open events' }}</p>
        </div>
        <div class="bg-white p-5 text-center sm:p-6">
            <p class="text-2xl font-bold tracking-tight text-emerald-600 sm:text-3xl" data-count="{{ $stats['agencies'] }}">0</p>
            <p class="mt-1 text-xs font-medium uppercase tracking-wide text-slate-500 sm:text-sm">{{ $stats['agencies'] === 1 ? 'Partner agency' : 'Partner agencies' }}</p>
        </div>
        <div class="bg-white p-5 text-center sm:p-6">
            <p class="text-2xl font-bold tracking-tight text-indigo-600 sm:text-3xl" data-count="{{ $stats['users'] }}">0</p>
            <p class="mt-1 text-xs font-medium uppercase tracking-wide text-slate-500 sm:text-sm">{{ $stats['users'] === 1 ? 'Registered user' : 'Registered users' }}</p>
        </div>
        <div class="bg-white p-5 text-center sm:p-6">
            <p class="text-2xl font-bold tracking-tight text-amber-600 sm:text-3xl" data-count="{{ $stats['registrations'] }}">0</p>
            <p class="mt-1 text-xs font-medium uppercase tracking-wide text-slate-500 sm:text-sm">{{ $stats['registrations'] === 1 ? 'Registration' : 'Registrations' }}</p>
        </div>
    </div>
</section>

{{-- ================= SEARCH ================= --}}
<section class="mx-auto mt-10 max-w-7xl px-4 sm:px-6 lg:px-8" id="events">
    <div class="card p-5 sm:p-6" data-reveal>
        <form method="GET" action="{{ route('events.search') }}" class="grid gap-3 md:grid-cols-[1fr_auto_auto_auto] md:items-end">
            <div>
                <label class="label" for="keyword">Search events</label>
                <div class="relative">
                    <svg class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                    <input id="keyword" type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Search by title or keyword..." class="input pl-9">
                </div>
            </div>
            <div>
                <label class="label" for="category_id">Category</label>
                <select id="category_id" name="category_id" class="input">
                    <option value="">All categories</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->category_id }}" @selected(request('category_id') == $category->category_id)>{{ $category->category_name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="label" for="date">Date</label>
                <input id="date" type="date" name="date" value="{{ request('date') }}" class="input">
            </div>
            <button type="submit" class="btn btn-primary w-full md:w-auto md:px-8">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>
                Search
            </button>
        </form>

        {{-- Quick filter chips --}}
        <div class="mt-4 flex flex-wrap items-center gap-2 border-t border-slate-100 pt-4">
            <span class="text-xs font-semibold uppercase tracking-wide text-slate-400">Quick filters</span>
            <a href="{{ route('events.search') }}"
               class="rounded-full px-3 py-1 text-xs font-medium ring-1 ring-inset transition {{ !request('category_id') && !request('keyword') && !request('date') ? 'bg-primary-700 text-white ring-primary-700' : 'bg-white text-slate-600 ring-slate-200 hover:bg-slate-50' }}">
                All
            </a>
            @foreach ($categories as $category)
                @php $chip = category_style($category->category_name, $categoryStyles)['chip']; @endphp
                @if ($category->events_count === 0)
                    <span class="cursor-not-allowed rounded-full bg-slate-50 px-3 py-1 text-xs font-medium text-slate-400 ring-1 ring-inset ring-slate-200" title="No upcoming events in this category">
                        {{ $category->category_name }} ({{ $category->events_count }})
                    </span>
                @else
                    <a href="{{ route('events.search', ['category_id' => $category->category_id]) }}"
                       class="rounded-full px-3 py-1 text-xs font-medium ring-1 ring-inset transition {{ request('category_id') == $category->category_id ? 'bg-primary-700 text-white ring-primary-700' : $chip . ' hover:opacity-80' }}">
                        {{ $category->category_name }} ({{ $category->events_count }})
                    </a>
                @endif
            @endforeach
        </div>
    </div>
</section>

{{-- ================= CATEGORIES ================= --}}
@if ($categories->isNotEmpty() && !request()->hasAny(['keyword', 'category_id', 'date']))
<section class="mx-auto mt-12 max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold tracking-tight text-slate-900">Browse by category</h2>
            <p class="mt-0.5 text-sm text-slate-500">Find the right programme for you.</p>
        </div>
    </div>
    <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 xl:grid-cols-6">
        @foreach ($categories as $category)
            @php $style = category_style($category->category_name, $categoryStyles); @endphp
            <a href="{{ route('events.search', ['category_id' => $category->category_id]) }}"
               data-reveal style="--reveal-delay: {{ ($loop->index % 6) * 60 }}ms"
               class="group card flex items-center gap-4 p-5 transition duration-200 hover:-translate-y-0.5 hover:shadow-lg">
                <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br {{ $style['grad'] }} text-white shadow-md transition duration-200 group-hover:scale-110">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $style['icon'] }}" />
                    </svg>
                </span>
                <div class="min-w-0">
                    <p class="leading-snug font-semibold text-slate-900 group-hover:text-primary-700">{{ $category->category_name }}</p>
                    <p class="mt-0.5 text-xs text-slate-500">{{ $category->events_count }} event{{ $category->events_count === 1 ? '' : 's' }}</p>
                </div>
                <svg class="ml-auto h-4 w-4 shrink-0 text-slate-300 transition group-hover:translate-x-0.5 group-hover:text-primary-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
            </a>
        @endforeach
    </div>
</section>
@endif

{{-- ================= EVENTS ================= --}}
<section class="mx-auto mt-12 max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="mb-6 flex items-end justify-between gap-4" data-reveal>
        <div>
            <h2 class="text-xl font-bold tracking-tight text-slate-900">
                {{ request()->hasAny(['keyword', 'category_id', 'date']) ? 'Search results' : 'Upcoming events' }}
            </h2>
            <p class="mt-0.5 text-sm text-slate-500">
                @if (request()->hasAny(['keyword', 'category_id', 'date']))
                    Showing {{ $events->total() }} event{{ $events->total() === 1 ? '' : 's' }} matching your filters.
                @else
                    Registration is free and open to all eligible participants.
                @endif
            </p>
        </div>
        @if (request()->hasAny(['keyword', 'category_id', 'date']))
            <a href="{{ route('events.search') }}" class="btn btn-secondary btn-sm shrink-0">Clear filters</a>
        @endif
    </div>

    @if ($events->isEmpty())
        <x-ui.empty title="No events found" message="Try adjusting your search filters or check back later for new programs." data-reveal>
            @if (request()->hasAny(['keyword', 'category_id', 'date']))
                <a href="{{ route('events.search') }}" class="btn btn-primary btn-sm">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Clear filters
                </a>
            @endif
        </x-ui.empty>
    @else
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach ($events as $event)
                @php
                    $style = category_style($event->category->category_name ?? '', $categoryStyles);
                    $registered = $event->registrations_count ?? 0;
                    $capacity = $event->capacity ?: 0;
                    $pct = $capacity ? min(100, (int) round($registered / $capacity * 100)) : 0;
                    $full = $pct >= 100;
                    $warning = $pct >= 90 && !$full;
                    $status = $statusMeta[$event->status] ?? $statusMeta['open'];
                    $eventDate = \Carbon\Carbon::parse($event->date);
                @endphp

                <article data-reveal style="--reveal-delay: {{ ($loop->index % 6) * 60 }}ms"
                         class="group card flex flex-col overflow-hidden transition duration-200 hover:-translate-y-1 hover:shadow-xl">
                    {{-- Card header / "image" --}}
                    <a href="{{ route('events.show', $event) }}" class="relative block h-32 overflow-hidden bg-gradient-to-br {{ $style['head'] }}">
                        <div class="absolute inset-0 opacity-25" style="background-image: radial-gradient(circle at 80% 20%, rgba(255,255,255,0.5) 0, transparent 45%), radial-gradient(circle at 20% 90%, rgba(255,255,255,0.35) 0, transparent 40%);"></div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <svg class="h-10 w-10 text-white/60 transition duration-300 group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke-width="1.2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $style['icon'] }}" />
                            </svg>
                        </div>

                        {{-- Date chip --}}
                        <span class="absolute left-3 top-3 flex h-11 w-11 flex-col items-center justify-center rounded-xl bg-white/95 text-primary-800 shadow-sm ring-1 ring-white/40 backdrop-blur">
                            <span class="text-sm font-bold leading-none">{{ $eventDate->format('d') }}</span>
                            <span class="mt-0.5 text-[9px] font-semibold uppercase tracking-wide">{{ $eventDate->format('M') }}</span>
                        </span>

                        {{-- Status badges --}}
                        <div class="absolute right-3 top-3 flex flex-col items-end gap-1.5">
                            <x-ui.badge type="{{ $status['tone'] }}">
                                <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $status['icon'] }}" />
                                </svg>
                                {{ ucfirst($event->status) }}
                            </x-ui.badge>
                            @if ($full)
                                <x-ui.badge type="danger">
                                    <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                                    </svg>
                                    Full
                                </x-ui.badge>
                            @endif
                        </div>

                        {{-- Bottom date/time overlay --}}
                        <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/55 to-transparent px-4 pb-2.5 pt-6">
                            <p class="flex items-center gap-1.5 text-xs font-medium text-white">
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                </svg>
                                {{ $eventDate->format('l, d M Y') }} · {{ $event->time }}
                            </p>
                        </div>
                    </a>

                    {{-- Card body --}}
                    <div class="flex flex-1 flex-col p-5">
                        <div class="flex items-center gap-2">
                            <x-ui.badge type="info">{{ $event->category->category_name ?? 'General' }}</x-ui.badge>
                            <span class="flex min-w-0 items-center gap-1 truncate text-xs text-slate-400">
                                <svg class="h-3.5 w-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                                </svg>
                                <span class="truncate">{{ $event->agency->agency_name ?? '' }}</span>
                            </span>
                        </div>

                        <a href="{{ route('events.show', $event) }}">
                            <h3 class="mt-3 line-clamp-2 text-lg font-bold leading-snug text-slate-900 transition group-hover:text-primary-700">
                                {{ $event->title }}
                            </h3>
                        </a>

                        <p class="mt-2 flex items-center gap-1.5 text-sm text-slate-500">
                            <svg class="h-4 w-4 shrink-0 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                            </svg>
                            <span class="truncate">{{ $event->venue }}</span>
                        </p>

                        {{-- Capacity progress --}}
                        <div class="mt-4">
                            <div class="mb-1.5 flex items-center justify-between text-xs">
                                <span class="font-medium text-slate-500">Capacity</span>
                                <span class="font-semibold {{ $full ? 'text-rose-600' : ($warning ? 'text-amber-600' : 'text-primary-700') }}">
                                    {{ $registered }} / {{ $capacity }} filled
                                </span>
                            </div>
                            <div class="h-3 w-full overflow-hidden rounded-full bg-slate-100">
                                <div class="h-full rounded-full {{ $full ? 'bg-rose-500' : ($warning ? 'bg-amber-500' : 'bg-gradient-to-r from-primary-600 to-primary-400') }} transition-all duration-500" style="width: {{ $pct }}%"></div>
                            </div>
                        </div>

                        {{-- Card footer --}}
                        <div class="mt-5 flex items-center gap-3 border-t border-slate-100 pt-4">
                            <a href="{{ route('events.show', $event) }}" class="btn {{ $full ? 'btn-secondary' : 'btn-primary' }} flex-1">
                                @if ($full)
                                    View details
                                @else
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 010 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 010-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375z" />
                                    </svg>
                                    Register now
                                @endif
                            </a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    @endif

    <div class="mt-8" data-reveal>
        {{ $events->links('vendor.pagination.custom') }}
    </div>
</section>

{{-- ================= TRUST BADGES ================= --}}
@if ($agencies->isNotEmpty())
<section class="mx-auto mt-16 max-w-7xl px-4 sm:px-6 lg:px-8" data-reveal>
    <div class="card px-6 py-8 text-center">
        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Trusted by Malaysian government agencies</p>
        <div class="mt-5 flex flex-wrap items-center justify-center gap-3">
            @foreach ($agencies as $agency)
                <span class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-slate-50 px-4 py-2 text-sm font-semibold text-slate-600 transition hover:border-primary-200 hover:bg-white">
                    <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-gradient-to-br from-primary-600 to-primary-800 text-white">
                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                        </svg>
                    </span>
                    {{ $agency->agency_name }}
                </span>
            @endforeach
        </div>
        <p class="mt-6 flex items-center justify-center gap-2 text-xs text-slate-400">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
            </svg>
            A secure and trusted government digital service
        </p>
    </div>
</section>
@endif
@endsection

@section('scripts')
<script>
    (function () {
        const counters = document.querySelectorAll('[data-count]');
        if (!counters.length) return;

        const animate = (el) => {
            const target = parseInt(el.dataset.count, 10) || 0;
            const duration = 900;
            const start = performance.now();
            const step = (now) => {
                const progress = Math.min((now - start) / duration, 1);
                const eased = 1 - Math.pow(1 - progress, 3);
                el.textContent = Math.round(target * eased).toLocaleString('en-MY');
                if (progress < 1) requestAnimationFrame(step);
            };
            requestAnimationFrame(step);
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    animate(entry.target);
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.4 });

        counters.forEach((el) => observer.observe(el));
    })();

    // Scroll-reveal fade-in effects
    document.documentElement.classList.add('js-reveal');
    const revealEls = document.querySelectorAll('[data-reveal]');
    if ('IntersectionObserver' in window) {
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    revealObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1, rootMargin: '0px 0px -32px 0px' });
        revealEls.forEach((el) => revealObserver.observe(el));
    } else {
        revealEls.forEach((el) => el.classList.add('is-visible'));
    }
</script>
@endsection
