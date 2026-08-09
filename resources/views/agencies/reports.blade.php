@extends('layouts.app')
@section('title', 'Agency Reports')

@section('content')
<x-ui.page-header :title="$agency->agency_name . ' — Event reports'"
    :subtitle="'Overview of all events organised by this agency.'">
    <x-ui.badge type="info">{{ $agency->agency_code }}</x-ui.badge>
</x-ui.page-header>

<div class="grid gap-5 sm:grid-cols-3">
    <x-ui.stat label="Total events" :value="$agency->events_count" tone="primary"
        icon="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
    <x-ui.stat label="Total registrations" :value="$events->sum('registrations_count')" tone="indigo"
        icon="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
    <x-ui.stat label="Open events" :value="$events->where('status', 'open')->count()" tone="emerald"
        icon="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
</div>

<div class="card mt-6 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-left">
                <tr>
                    <th class="th">Event</th>
                    <th class="th hidden md:table-cell">Date</th>
                    <th class="th">Status</th>
                    <th class="th hidden sm:table-cell">Registrations</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($events as $event)
                    <tr class="transition hover:bg-slate-50">
                        <td class="td font-semibold text-slate-900">
                            <a href="{{ route('events.show', $event) }}" class="hover:text-primary-700">{{ $event->title }}</a>
                        </td>
                        <td class="td hidden md:table-cell">{{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}</td>
                        <td class="td">
                            <x-ui.badge type="{{ $event->status === 'open' ? 'success' : 'neutral' }}">{{ ucfirst($event->status) }}</x-ui.badge>
                        </td>
                        <td class="td hidden sm:table-cell">{{ $event->registrations_count }} / {{ $event->capacity }}</td>
                    </tr>
                @empty
                    <tr>
                        <td class="td" colspan="4">
                            <p class="py-6 text-center text-sm text-slate-500">No events organised by this agency yet.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-6">{{ $events->links() }}</div>
@endsection
