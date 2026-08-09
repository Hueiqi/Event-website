@extends('layouts.app')
@section('title', 'Manage Users')

@section('content')
<x-ui.page-header
    :title="auth()->user()->isAdmin() ? 'Manage users' : 'Manage event organizers'"
    subtitle="Accounts registered on the platform." />

@if (auth()->user()->isAgencyAdmin())
    <div class="card mb-6 p-6">
        <h2 class="text-base font-bold text-slate-900">Add event organizer</h2>
        <p class="mt-1 text-sm text-slate-500">Create an organizer account for your agency.</p>
        <form method="POST" action="{{ route('organizers.store') }}" class="mt-4 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @csrf
            <input type="text" name="name" placeholder="Full name" required class="input">
            <input type="email" name="email" placeholder="Email address" required class="input">
            <input type="password" name="password" placeholder="Temporary password" required class="input">
            <input type="hidden" name="role" value="organizer">
            <input type="hidden" name="user_type" value="government">
            <button type="submit" class="btn btn-primary">Add organizer</button>
        </form>
    </div>
@endif

@if ($users->isEmpty())
    <x-ui.empty title="No users found" message="User accounts will appear here once they register." />
@else
    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-left">
                    <tr>
                        <th class="th">User</th>
                        <th class="th hidden sm:table-cell">Role</th>
                        @if (auth()->user()->isAdmin())
                            <th class="th hidden md:table-cell">Agency</th>
                        @endif
                        <th class="th text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($users as $user)
                        <tr class="transition hover:bg-slate-50">
                            <td class="td">
                                <div class="flex items-center gap-3">
                                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-primary-100 text-sm font-bold text-primary-800">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </span>
                                    <div class="min-w-0">
                                        <p class="truncate font-semibold text-slate-900">{{ $user->name }}</p>
                                        <p class="truncate text-xs text-slate-500">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="td hidden sm:table-cell">
                                <x-ui.badge type="{{ $user->isAdmin() ? 'danger' : ($user->isOrganizer() ? 'info' : 'neutral') }}">
                                    {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                                </x-ui.badge>
                            </td>
                            @if (auth()->user()->isAdmin())
                                <td class="td hidden md:table-cell">{{ $user->agency->agency_name ?? '—' }}</td>
                            @endif
                            <td class="td">
                                <div class="flex justify-end">
                                    @if ($user->id !== auth()->id())
                                        <form method="POST" action="{{ route('users.destroy', $user) }}"
                                              onsubmit="return confirm('Suspend/delete this account?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                                        </form>
                                    @else
                                        <span class="text-xs text-slate-400">You</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">{{ $users->links() }}</div>
@endif
@endsection
