@extends('layouts.app')
@section('title', 'Manage Events')

@section('content')
<x-ui.page-header
    :title="auth()->user()->isAdmin() ? 'All events' : 'My agency events'"
    subtitle="Manage event details, registrations and attendance.">
    <a href="{{ route('events.create') }}" class="btn btn-primary">
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
        Create event
    </a>
</x-ui.page-header>

@if ($events->isEmpty())
    <x-ui.empty title="No events found" message="Create your first event to get started.">
        <a href="{{ route('events.create') }}" class="btn btn-primary">Create event</a>
    </x-ui.empty>
@else
    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-left">
                    <tr>
                        <th class="th">Event</th>
                        <th class="th hidden md:table-cell">Agency</th>
                        <th class="th hidden lg:table-cell">Date</th>
                        <th class="th">Status</th>
                        <th class="th text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($events as $event)
                        <tr class="transition hover:bg-slate-50">
                            <td class="td">
                                <a href="{{ route('events.show', $event) }}" class="font-semibold text-slate-900 hover:text-primary-700">{{ $event->title }}</a>
                                <p class="mt-0.5 text-xs text-slate-400">{{ $event->registrations_count ?? $event->registrations()->count() }} registrations</p>
                            </td>
                            <td class="td hidden md:table-cell">{{ $event->agency->agency_name ?? '—' }}</td>
                            <td class="td hidden lg:table-cell">{{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}</td>
                            <td class="td">
                                <x-ui.badge type="{{ $event->status === 'open' ? 'success' : ($event->status === 'cancelled' ? 'danger' : 'neutral') }}">{{ ucfirst($event->status) }}</x-ui.badge>
                            </td>
                            <td class="td">
                                <div class="flex justify-end gap-1.5">
                                    <a href="{{ route('events.registrations', $event) }}" class="btn btn-secondary btn-sm">Registrations</a>
                                    <a href="{{ route('events.report', $event) }}" class="btn btn-secondary btn-sm">Report</a>
                                    <a href="{{ route('events.edit', $event) }}" class="btn btn-secondary btn-sm">Edit</a>
                                    <form method="POST" action="{{ route('events.destroy', $event) }}"
                                          onsubmit="return confirm('Cancel this event? Registered participants will be notified.');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Cancel</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">{{ $events->links() }}</div>
@endif
@endsection
