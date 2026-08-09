@extends('layouts.app')
@section('title', 'Event Report')

@section('content')
<a href="{{ route('events.index') }}" class="mb-4 inline-flex items-center gap-1.5 text-sm font-semibold text-slate-500 hover:text-primary-700">
    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
    </svg>
    Back to events
</a>

<x-ui.page-header :title="'Attendance report: ' . $event->title"
    :subtitle="\Carbon\Carbon::parse($event->date)->format('l, d F Y') . ' · ' . $event->venue">
    <span class="text-sm text-slate-500">
        {{ \Carbon\Carbon::parse($event->date)->isPast() ? 'Completed' : 'Upcoming' }} event
    </span>
</x-ui.page-header>

@php
    $total = $event->registrations->count();
    $attended = $event->registrations->where('status', 'attended')->count();
    $cancelled = $event->registrations->where('status', 'cancelled')->count();
    $active = $total - $cancelled;
@endphp

<div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
    <x-ui.stat label="Total registered" :value="$total" tone="primary"
        icon="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
    <x-ui.stat label="Active participants" :value="$active" tone="indigo"
        icon="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
    <x-ui.stat label="Attended" :value="$attended" tone="emerald"
        icon="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
    <x-ui.stat label="Cancelled" :value="$cancelled" tone="rose"
        icon="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
</div>

<div class="mt-6">
    <div class="card p-6">
        <div class="mb-4 flex items-center justify-between">
            <h2 class="text-base font-bold text-slate-900">Attendance breakdown</h2>
            <span class="text-sm text-slate-500">{{ $active ? round($attended / max($active, 1) * 100) : 0 }}% attendance</span>
        </div>
        <div class="flex h-3 w-full overflow-hidden rounded-full bg-slate-100">
            @if ($total > 0)
                <div class="bg-emerald-500" style="width: {{ $attended / $total * 100 }}%"></div>
                <div class="bg-slate-300" style="width: {{ ($active - $attended) / $total * 100 }}%"></div>
                <div class="bg-rose-400" style="width: {{ $cancelled / $total * 100 }}%"></div>
            @endif
        </div>
        <div class="mt-3 flex flex-wrap gap-4 text-xs text-slate-500">
            <span class="flex items-center gap-1.5"><span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span>Attended</span>
            <span class="flex items-center gap-1.5"><span class="h-2.5 w-2.5 rounded-full bg-slate-300"></span>Registered</span>
            <span class="flex items-center gap-1.5"><span class="h-2.5 w-2.5 rounded-full bg-rose-400"></span>Cancelled</span>
        </div>
    </div>
</div>

<div class="card mt-6 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-left">
                <tr>
                    <th class="th">Name</th>
                    <th class="th hidden sm:table-cell">Email</th>
                    <th class="th">Status</th>
                    <th class="th hidden md:table-cell">Questionnaire</th>
                    <th class="th hidden lg:table-cell">Certificate</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($event->registrations as $reg)
                    <tr class="transition hover:bg-slate-50">
                        <td class="td font-semibold text-slate-900">{{ $reg->user->name }}</td>
                        <td class="td hidden sm:table-cell">{{ $reg->user->email }}</td>
                        <td class="td">
                            <x-ui.badge type="{{ $reg->status === 'attended' ? 'success' : ($reg->status === 'cancelled' ? 'danger' : 'info') }}">{{ ucfirst($reg->status) }}</x-ui.badge>
                        </td>
                        <td class="td hidden md:table-cell">
                            <x-ui.badge type="{{ $reg->questionnaire_completed ? 'success' : 'neutral' }}">{{ $reg->questionnaire_completed ? 'Completed' : 'Pending' }}</x-ui.badge>
                        </td>
                        <td class="td hidden lg:table-cell text-slate-500">{{ $reg->certificate_generated ? 'Generated' : '—' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td class="td" colspan="5">
                            <p class="py-6 text-center text-sm text-slate-500">No registrations for this event yet.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
