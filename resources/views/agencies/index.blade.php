@extends('layouts.app')
@section('title', 'Manage Agencies')

@section('content')
<x-ui.page-header title="Government agencies" subtitle="Registered agencies and their activity.">
    <a href="{{ route('agencies.create') }}" class="btn btn-primary">
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
        Register agency
    </a>
</x-ui.page-header>

@if ($agencies->isEmpty())
    <x-ui.empty title="No agencies registered" message="Register the first government agency to get started.">
        <a href="{{ route('agencies.create') }}" class="btn btn-primary">Register agency</a>
    </x-ui.empty>
@else
    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-left">
                    <tr>
                        <th class="th">Agency</th>
                        <th class="th hidden sm:table-cell">Code</th>
                        <th class="th hidden md:table-cell">Users</th>
                        <th class="th hidden md:table-cell">Events</th>
                        <th class="th text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($agencies as $agency)
                        <tr class="transition hover:bg-slate-50">
                            <td class="td">
                                <div class="flex items-center gap-3">
                                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-primary-100 text-sm font-bold text-primary-800">
                                        {{ strtoupper(substr($agency->agency_code ?? $agency->agency_name, 0, 1)) }}
                                    </span>
                                    <div>
                                        <p class="font-semibold text-slate-900">{{ $agency->agency_name }}</p>
                                        <p class="text-xs text-slate-500">{{ $agency->email ?? '' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="td hidden sm:table-cell">
                                <x-ui.badge type="neutral">{{ $agency->agency_code }}</x-ui.badge>
                            </td>
                            <td class="td hidden md:table-cell">{{ $agency->users_count }}</td>
                            <td class="td hidden md:table-cell">{{ $agency->events_count }}</td>
                            <td class="td">
                                <div class="flex justify-end gap-1.5">
                                    <a href="{{ route('agencies.edit', $agency) }}" class="btn btn-secondary btn-sm">Edit</a>
                                    <form method="POST" action="{{ route('agencies.destroy', $agency) }}"
                                          onsubmit="return confirm('Remove this agency? This cannot be undone.');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">{{ $agencies->links() }}</div>
@endif
@endsection
