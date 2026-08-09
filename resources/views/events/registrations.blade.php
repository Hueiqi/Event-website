@extends('layouts.app')
@section('title', 'Manage Registrations')

@section('content')
<a href="{{ route('events.index') }}" class="mb-4 inline-flex items-center gap-1.5 text-sm font-semibold text-slate-500 hover:text-primary-700">
    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
    </svg>
    Back to events
</a>

<x-ui.page-header :title="$event->title"
    :subtitle="\Carbon\Carbon::parse($event->date)->format('l, d F Y') . ' · ' . $event->venue">
    <x-ui.badge type="{{ $event->status === 'open' ? 'success' : 'neutral' }}">{{ ucfirst($event->status) }}</x-ui.badge>
</x-ui.page-header>

<div class="grid gap-6 lg:grid-cols-3">
    <div class="space-y-6 lg:col-span-1">
        {{-- Announcement --}}
        <div class="card p-6">
            <h2 class="text-base font-bold text-slate-900">Send announcement</h2>
            <p class="mt-1 text-sm text-slate-500">Message all registered participants.</p>
            <form method="POST" action="{{ route('events.announce', $event) }}" class="mt-4">
                @csrf
                <textarea name="message" rows="3" required placeholder="Message to all participants..."
                          class="input"></textarea>
                <button type="submit" class="btn btn-primary mt-3 w-full">Send announcement</button>
            </form>
        </div>

        {{-- Materials --}}
        <div class="card p-6">
            <h2 class="text-base font-bold text-slate-900">Presentation materials</h2>
            <p class="mt-1 text-sm text-slate-500">Upload files participants can download.</p>
            <form method="POST" action="{{ route('materials.store', $event) }}" enctype="multipart/form-data" class="mt-4 space-y-3">
                @csrf
                <input type="text" name="title" placeholder="Material title" required class="input">
                <input type="file" name="file" required class="input file:mr-3 file:rounded-md file:border-0 file:bg-primary-50 file:px-3 file:py-1.5 file:text-sm file:font-semibold file:text-primary-700 hover:file:bg-primary-100">
                <button type="submit" class="btn btn-secondary w-full">Upload material</button>
            </form>

            @if ($event->materials->isNotEmpty())
                <ul class="mt-4 divide-y divide-slate-100">
                    @foreach ($event->materials as $material)
                        <li class="flex items-center justify-between gap-3 py-2.5 text-sm">
                            <span class="truncate text-slate-700">{{ $material->title }}</span>
                            <form method="POST" action="{{ route('materials.destroy', $material) }}"
                                  onsubmit="return confirm('Remove this material?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-rose-600 hover:underline">Remove</button>
                            </form>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

    {{-- Registrations --}}
    <div class="lg:col-span-2">
        <div class="card overflow-hidden">
            <div class="border-b border-slate-100 px-5 py-4">
                <h2 class="text-base font-bold text-slate-900">
                    Registered participants
                    <span class="ml-1 rounded-full bg-primary-100 px-2.5 py-0.5 text-xs font-semibold text-primary-800">{{ $registrations->total() }}</span>
                </h2>
            </div>

            @if ($registrations->isEmpty())
                <div class="p-6">
                    <x-ui.empty title="No registrations yet" message="Participants who register for this event will appear here." />
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-slate-50 text-left">
                            <tr>
                                <th class="th">Participant</th>
                                <th class="th hidden sm:table-cell">Status</th>
                                <th class="th text-right">Attendance</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($registrations as $reg)
                                <tr class="transition hover:bg-slate-50">
                                    <td class="td">
                                        <div class="flex items-center gap-3">
                                            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-primary-100 text-sm font-bold text-primary-800">
                                                {{ strtoupper(substr($reg->user->name, 0, 1)) }}
                                            </span>
                                            <div class="min-w-0">
                                                <p class="truncate font-semibold text-slate-900">{{ $reg->user->name }}</p>
                                                <p class="truncate text-xs text-slate-500">{{ $reg->user->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="td hidden sm:table-cell">
                                        <x-ui.badge type="{{ $reg->status === 'attended' ? 'success' : ($reg->status === 'cancelled' ? 'danger' : 'info') }}">{{ ucfirst($reg->status) }}</x-ui.badge>
                                    </td>
                                    <td class="td">
                                        <div class="flex justify-end">
                                            @if ($reg->checked_in)
                                                <span class="inline-flex items-center gap-1.5 text-sm font-medium text-emerald-600">
                                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    Checked in {{ \Carbon\Carbon::parse($reg->checked_in_at)->format('d M, H:i') }}
                                                </span>
                                            @elseif ($reg->status === 'registered')
                                                <form method="POST" action="{{ route('registrations.attendance', [$event, $reg]) }}">
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary btn-sm">Mark attended</button>
                                                </form>
                                            @else
                                                <span class="text-sm text-slate-300">—</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="border-t border-slate-100 px-5 py-4">
                    {{ $registrations->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
