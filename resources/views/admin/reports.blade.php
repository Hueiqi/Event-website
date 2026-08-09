@extends('layouts.app')
@section('title', 'System Reports')

@section('content')
<x-ui.page-header title="System-wide event reports" subtitle="Overview of all events across agencies." />

<div class="card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-left">
                <tr>
                    <th class="th">Event</th>
                    <th class="th hidden md:table-cell">Agency</th>
                    <th class="th hidden lg:table-cell">Date</th>
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
                        <td class="td hidden md:table-cell">{{ $event->agency->agency_name ?? '—' }}</td>
                        <td class="td hidden lg:table-cell">{{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}</td>
                        <td class="td">
                            <x-ui.badge type="{{ $event->status === 'open' ? 'success' : ($event->status === 'cancelled' ? 'danger' : 'neutral') }}">{{ ucfirst($event->status) }}</x-ui.badge>
                        </td>
                        <td class="td hidden sm:table-cell">{{ $event->registrations_count }} / {{ $event->capacity }}</td>
                    </tr>
                @empty
                    <tr>
                        <td class="td" colspan="5">
                            <p class="py-6 text-center text-sm text-slate-500">No events found.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-6">{{ $events->links() }}</div>
@endsection
