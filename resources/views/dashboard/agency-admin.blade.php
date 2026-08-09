@extends('layouts.app')
@section('title', 'Agency Admin Dashboard')

@section('content')
<x-ui.page-header title="Agency Dashboard" subtitle="{{ auth()->user()->agency->agency_name ?? 'Your agency' }}">
    <a href="{{ route('events.create') }}" class="btn btn-primary">
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
        Create event
    </a>
</x-ui.page-header>

<div class="mb-8 flex flex-wrap gap-3">
    <a href="{{ route('agency.edit') }}" class="btn btn-secondary">Agency profile</a>
    <a href="{{ route('organizers.index') }}" class="btn btn-secondary">Manage organizers</a>
    <a href="{{ route('agency.reports') }}" class="btn btn-secondary">Agency reports</a>
</div>

<div class="grid gap-6 lg:grid-cols-2">
    <div class="card p-6">
        <div class="flex items-center justify-between">
            <h2 class="text-base font-bold text-slate-900">Recent events</h2>
            <a href="{{ route('events.index') }}" class="text-sm font-semibold text-primary-700 hover:underline">View all</a>
        </div>
        <ul class="mt-4 divide-y divide-slate-100">
            @forelse ($events as $event)
                <li class="flex items-center justify-between gap-3 py-3">
                    <div class="min-w-0">
                        <p class="truncate text-sm font-semibold text-slate-900">
                            <a href="{{ route('events.show', $event) }}" class="hover:text-primary-700">{{ $event->title }}</a>
                        </p>
                        <p class="mt-0.5 text-xs text-slate-500">{{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}</p>
                    </div>
                    <x-ui.badge type="{{ $event->status === 'open' ? 'success' : 'neutral' }}">{{ ucfirst($event->status) }}</x-ui.badge>
                </li>
            @empty
                <li class="py-6 text-center text-sm text-slate-500">No events created yet.</li>
            @endforelse
        </ul>
    </div>

    <div class="card p-6">
        <div class="flex items-center justify-between">
            <h2 class="text-base font-bold text-slate-900">Event organizers</h2>
            <a href="{{ route('organizers.index') }}" class="text-sm font-semibold text-primary-700 hover:underline">Manage</a>
        </div>
        <ul class="mt-4 divide-y divide-slate-100">
            @forelse ($organizers as $organizer)
                <li class="flex items-center gap-3 py-3">
                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-primary-100 text-sm font-bold text-primary-800">
                        {{ strtoupper(substr($organizer->name, 0, 1)) }}
                    </span>
                    <div class="min-w-0">
                        <p class="truncate text-sm font-semibold text-slate-900">{{ $organizer->name }}</p>
                        <p class="truncate text-xs text-slate-500">{{ $organizer->email }}</p>
                    </div>
                </li>
            @empty
                <li class="py-6 text-center text-sm text-slate-500">No organizers assigned yet.</li>
            @endforelse
        </ul>
    </div>
</div>
@endsection
