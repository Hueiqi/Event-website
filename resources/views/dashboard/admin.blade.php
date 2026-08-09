@extends('layouts.app')
@section('title', 'System Admin Dashboard')

@section('content')
<x-ui.page-header title="System Overview" subtitle="Welcome back, {{ auth()->user()->name }}. Here is the latest activity across the platform.">
    <a href="{{ route('events.create') }}" class="btn btn-primary">
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
        New event
    </a>
</x-ui.page-header>

<div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
    <x-ui.stat label="Government agencies" :value="number_format($stats['agencies'])" tone="primary"
        icon="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
    <x-ui.stat label="Registered users" :value="number_format($stats['users'])" tone="indigo"
        icon="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM3 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 019.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
    <x-ui.stat label="Total events" :value="number_format($stats['events'])" tone="emerald"
        icon="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
    <x-ui.stat label="Event registrations" :value="number_format($stats['registrations'])" tone="amber"
        icon="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
</div>

<div class="mt-8 grid gap-6 lg:grid-cols-3">
    <div class="card p-6">
        <h2 class="text-base font-bold text-slate-900">Management</h2>
        <p class="mt-1 text-sm text-slate-500">Manage the core entities of the platform.</p>
        <nav class="mt-5 space-y-1">
            <a href="{{ route('agencies.index') }}" class="group flex items-center justify-between rounded-xl px-3 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-primary-50 hover:text-primary-800">
                <span class="flex items-center gap-3">
                    <svg class="h-5 w-5 text-slate-400 group-hover:text-primary-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                    </svg>
                    Government agencies
                </span>
                <svg class="h-4 w-4 text-slate-300 group-hover:text-primary-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
            </a>
            <a href="{{ route('users.index') }}" class="group flex items-center justify-between rounded-xl px-3 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-primary-50 hover:text-primary-800">
                <span class="flex items-center gap-3">
                    <svg class="h-5 w-5 text-slate-400 group-hover:text-primary-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM3 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 019.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
                    </svg>
                    Users
                </span>
                <svg class="h-4 w-4 text-slate-300 group-hover:text-primary-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
            </a>
            <a href="{{ route('categories.index') }}" class="group flex items-center justify-between rounded-xl px-3 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-primary-50 hover:text-primary-800">
                <span class="flex items-center gap-3">
                    <svg class="h-5 w-5 text-slate-400 group-hover:text-primary-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
                    </svg>
                    Event categories
                </span>
                <svg class="h-4 w-4 text-slate-300 group-hover:text-primary-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
            </a>
            <a href="{{ route('admin.reports') }}" class="group flex items-center justify-between rounded-xl px-3 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-primary-50 hover:text-primary-800">
                <span class="flex items-center gap-3">
                    <svg class="h-5 w-5 text-slate-400 group-hover:text-primary-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                    </svg>
                    System reports
                </span>
                <svg class="h-4 w-4 text-slate-300 group-hover:text-primary-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
            </a>
            <a href="{{ route('admin.activity') }}" class="group flex items-center justify-between rounded-xl px-3 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-primary-50 hover:text-primary-800">
                <span class="flex items-center gap-3">
                    <svg class="h-5 w-5 text-slate-400 group-hover:text-primary-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Activity log
                </span>
                <svg class="h-4 w-4 text-slate-300 group-hover:text-primary-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
            </a>
        </nav>
    </div>

    <div class="card p-6 lg:col-span-2">
        <div class="flex items-center justify-between">
            <h2 class="text-base font-bold text-slate-900">Latest events</h2>
            <a href="{{ route('events.index') }}" class="text-sm font-semibold text-primary-700 hover:underline">View all</a>
        </div>
        <div class="mt-4 overflow-hidden rounded-xl ring-1 ring-slate-200">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-left">
                    <tr>
                        <th class="th">Event</th>
                        <th class="th hidden sm:table-cell">Agency</th>
                        <th class="th hidden md:table-cell">Date</th>
                        <th class="th">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach (\App\Models\Event::with(['agency', 'category'])->latest()->take(5)->get() as $latestEvent)
                        <tr class="hover:bg-slate-50">
                            <td class="td">
                                <a href="{{ route('events.show', $latestEvent) }}" class="font-semibold text-slate-900 hover:text-primary-700">{{ $latestEvent->title }}</a>
                            </td>
                            <td class="td hidden sm:table-cell">{{ $latestEvent->agency->agency_name ?? '—' }}</td>
                            <td class="td hidden md:table-cell">{{ \Carbon\Carbon::parse($latestEvent->date)->format('d M Y') }}</td>
                            <td class="td">
                                <x-ui.badge type="{{ $latestEvent->status === 'open' ? 'success' : 'neutral' }}">{{ ucfirst($latestEvent->status) }}</x-ui.badge>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
