@extends('layouts.app')
@section('title', 'Organizer Dashboard')

@section('content')
<x-ui.page-header title="My events" subtitle="Manage your events, registrations and attendance.">
    <a href="{{ route('events.create') }}" class="btn btn-primary">
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
        Create event
    </a>
</x-ui.page-header>

@if ($events->isEmpty())
    <x-ui.empty title="No events yet" message="Create your first event to start accepting registrations.">
        <a href="{{ route('events.create') }}" class="btn btn-primary">Create event</a>
    </x-ui.empty>
@else
    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-left">
                    <tr>
                        <th class="th">Event</th>
                        <th class="th hidden md:table-cell">Date</th>
                        <th class="th">Status</th>
                        <th class="th hidden sm:table-cell">Registrations</th>
                        <th class="th text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($events as $event)
                        <tr class="transition hover:bg-slate-50">
                            <td class="td">
                                <a href="{{ route('events.show', $event) }}" class="font-semibold text-slate-900 hover:text-primary-700">{{ $event->title }}</a>
                            </td>
                            <td class="td hidden md:table-cell">{{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}</td>
                            <td class="td">
                                <x-ui.badge type="{{ $event->status === 'open' ? 'success' : 'neutral' }}">{{ ucfirst($event->status) }}</x-ui.badge>
                            </td>
                            <td class="td hidden sm:table-cell">
                                <div class="flex items-center gap-2">
                                    <span class="font-semibold text-slate-900">{{ $event->registrations_count }}</span>
                                    <span class="text-slate-400">/ {{ $event->capacity }}</span>
                                    <div class="h-1.5 w-16 overflow-hidden rounded-full bg-slate-200">
                                        <div class="h-full rounded-full bg-primary-600" style="width: {{ $event->capacity ? min(100, round($event->registrations_count / $event->capacity * 100)) : 0 }}%"></div>
                                    </div>
                                </div>
                            </td>
                            <td class="td">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('events.registrations', $event) }}" class="btn btn-secondary btn-sm">Registrations</a>
                                    <a href="{{ route('events.report', $event) }}" class="btn btn-secondary btn-sm">Report</a>
                                    <a href="{{ route('events.edit', $event) }}" class="btn btn-secondary btn-sm">Edit</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif
@endsection
