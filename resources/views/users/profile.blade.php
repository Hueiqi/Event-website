@extends('layouts.app')
@section('title', 'My Profile')

@section('content')
@php
    $roleTones = [
        'admin' => 'danger',
        'agency_admin' => 'info',
        'organizer' => 'warning',
        'participant' => 'success',
    ];
    $prefs = $user->notification_preferences ?? [];
@endphp

{{-- User header --}}
<div class="relative mb-8 overflow-hidden rounded-2xl bg-gradient-to-r from-primary-800 via-primary-900 to-primary-950 px-6 py-8 text-white shadow-sm sm:px-8">
    <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
        <div class="flex items-center gap-5">
            {{-- Avatar with upload --}}
            <form method="POST" action="{{ route('profile.avatar') }}" enctype="multipart/form-data" class="relative shrink-0">
                @csrf @method('PUT')
                <label for="avatar" class="relative block cursor-pointer" title="Change profile photo">
                    @if ($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}"
                             class="h-20 w-20 rounded-full object-cover ring-2 ring-white/30 transition hover:ring-white/60">
                    @else
                        <span class="flex h-20 w-20 items-center justify-center rounded-full bg-white/15 text-3xl font-bold text-white ring-2 ring-white/30 transition hover:ring-white/60">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </span>
                    @endif
                    <span class="absolute -bottom-0.5 -right-0.5 flex h-7 w-7 items-center justify-center rounded-full bg-white text-primary-800 shadow-sm ring-2 ring-primary-900 transition group-hover:bg-primary-50">
                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316zM16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" />
                        </svg>
                    </span>
                    <input id="avatar" type="file" name="avatar" accept="image/*" class="sr-only" onchange="this.form.submit()">
                </label>
            </form>

            <div class="min-w-0">
                <h1 class="text-2xl font-bold tracking-tight">{{ $user->name }}</h1>
                <p class="mt-1 flex flex-wrap items-center gap-2 text-sm text-primary-100">
                    <span class="truncate">{{ $user->email }}</span>
                    <span class="h-1 w-1 rounded-full bg-primary-300"></span>
                    <span class="capitalize">{{ str_replace('_', ' ', $user->role) }}</span>
                </p>
                <div class="mt-2.5 flex flex-wrap items-center gap-2">
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-white/15 px-3 py-1 text-xs font-semibold text-white ring-1 ring-inset ring-white/20">
                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                        </svg>
                        {{ $user->email_verified_at ? 'Verified account' : 'Email not verified' }}
                    </span>
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-white/15 px-3 py-1 text-xs font-semibold text-white ring-1 ring-inset ring-white/20">
                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                        </svg>
                        Member since {{ \Carbon\Carbon::parse($user->created_at)->format('F Y') }}
                    </span>
                </div>
            </div>
        </div>

        <a href="{{ route('dashboard') }}" class="btn bg-white text-primary-800 shadow-sm hover:bg-primary-50">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h11.25M3.75 3l9 9m-4.5 8.25L15.75 6" />
            </svg>
            Back to dashboard
        </a>
    </div>
</div>

{{-- Statistics --}}
<div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
    <x-ui.stat label="Total registrations" :value="$stats['registrations']" tone="primary"
        icon="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
    <x-ui.stat label="Upcoming events" :value="$stats['upcoming']" tone="indigo"
        icon="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
    <x-ui.stat label="Events attended" :value="$stats['attended']" tone="emerald"
        icon="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
    <x-ui.stat label="Certificates earned" :value="$stats['certificates']" tone="amber"
        icon="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 01-.982-3.172M9.497 14.25a7.454 7.454 0 00.981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 007.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M7.73 9.728a6.726 6.726 0 002.748 1.35m8.272-6.842V4.5c0 2.108-.966 3.99-2.48 5.228m2.48-5.492a46.32 46.32 0 012.916.52 6.003 6.003 0 01-5.395 4.972m0 0a6.726 6.726 0 01-2.749 1.35m0 0a6.772 6.772 0 01-3.044 0" />
</div>

<div class="mt-8 grid gap-8 lg:grid-cols-3">
    {{-- Main column --}}
    <div class="space-y-8 lg:col-span-2">
        {{-- Personal info --}}
        <div class="card overflow-hidden">
            <div class="flex items-center gap-3 border-b border-slate-100 px-6 py-4">
                <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-primary-50 text-primary-700">
                    <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>
                </span>
                <div>
                    <h2 class="text-base font-bold text-slate-900">Personal information</h2>
                    <p class="text-xs text-slate-500">Update your basic account details</p>
                </div>
            </div>

            <form method="POST" action="{{ route('profile.update') }}" class="space-y-5 p-6 sm:p-8">
                @csrf @method('PUT')

                <div>
                    <label class="label" for="name">Full name</label>
                    <div class="relative">
                        <svg class="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                        </svg>
                        <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required class="input pl-10">
                    </div>
                    @error('name')<p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="label" for="email">Email address</label>
                    <div class="relative">
                        <svg class="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                        </svg>
                        <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required class="input pl-10">
                    </div>
                    @error('email')<p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="label" for="mykad">MyKad / Passport No.</label>
                    <div class="relative">
                        <svg class="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z" />
                        </svg>
                        <input id="mykad" type="text" name="mykad" value="{{ old('mykad', $user->mykad) }}" placeholder="Optional" class="input pl-10">
                    </div>
                </div>

                <div>
                    <label class="label" for="user_type">Account type</label>
                    <div class="relative">
                        <svg class="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                        </svg>
                        <input id="user_type" type="text" value="{{ ucfirst(str_replace('_', ' ', $user->user_type)) }}" disabled class="input bg-slate-100 pl-10 text-slate-500">
                    </div>
                </div>

                <div class="flex gap-3 border-t border-slate-100 pt-5">
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>

        {{-- Change password --}}
        <div class="card overflow-hidden">
            <div class="flex items-center gap-3 border-b border-slate-100 px-6 py-4">
                <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-amber-50 text-amber-700">
                    <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                    </svg>
                </span>
                <div>
                    <h2 class="text-base font-bold text-slate-900">Change password</h2>
                    <p class="text-xs text-slate-500">Use a strong password you don't use elsewhere</p>
                </div>
            </div>

            <form method="POST" action="{{ route('profile.password') }}" class="space-y-5 p-6 sm:p-8">
                @csrf @method('PUT')

                <div>
                    <label class="label" for="current_password">Current password</label>
                    <div class="relative">
                        <svg class="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                        </svg>
                        <input id="current_password" type="password" name="current_password" required class="input pl-10">
                    </div>
                    @error('current_password')<p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p>@enderror
                </div>

                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label class="label" for="password">New password</label>
                        <div class="relative">
                            <svg class="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                            </svg>
                            <input id="password" type="password" name="password" required minlength="8" class="input pl-10">
                        </div>
                        @error('password')<p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="label" for="password_confirmation">Confirm new password</label>
                        <div class="relative">
                            <svg class="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                            </svg>
                            <input id="password_confirmation" type="password" name="password_confirmation" required class="input pl-10">
                        </div>
                    </div>
                </div>

                <div class="flex gap-3 border-t border-slate-100 pt-5">
                    <button type="submit" class="btn btn-primary">Update password</button>
                </div>
            </form>
        </div>

        {{-- Notifications --}}
        <div class="card overflow-hidden">
            <div class="flex items-center gap-3 border-b border-slate-100 px-6 py-4">
                <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-indigo-50 text-indigo-700">
                    <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                    </svg>
                </span>
                <div>
                    <h2 class="text-base font-bold text-slate-900">Notification preferences</h2>
                    <p class="text-xs text-slate-500">Choose what you want to hear about</p>
                </div>
            </div>

            <form method="POST" action="{{ route('profile.notifications') }}">
                @csrf @method('PUT')

                <div class="divide-y divide-slate-100 px-6 py-2">
                    <label class="flex cursor-pointer items-center justify-between gap-4 py-3.5">
                        <span>
                            <span class="block text-sm font-medium text-slate-900">Event reminders</span>
                            <span class="block text-xs text-slate-500">Get reminded a few days before your upcoming events</span>
                        </span>
                        <span class="relative inline-flex h-6 w-11 shrink-0 items-center">
                            <input type="checkbox" name="preferences[]" value="upcoming_events"
                                class="peer sr-only" {{ in_array('upcoming_events', $prefs) ? 'checked' : '' }}>
                            <span class="absolute inset-0 rounded-full bg-slate-200 transition peer-checked:bg-primary-600"></span>
                            <span class="absolute left-0.5 h-5 w-5 rounded-full bg-white shadow transition peer-checked:translate-x-5"></span>
                        </span>
                    </label>

                    <label class="flex cursor-pointer items-center justify-between gap-4 py-3.5">
                        <span>
                            <span class="block text-sm font-medium text-slate-900">Event updates</span>
                            <span class="block text-xs text-slate-500">Changes to events you have registered for</span>
                        </span>
                        <span class="relative inline-flex h-6 w-11 shrink-0 items-center">
                            <input type="checkbox" name="preferences[]" value="event_updates"
                                class="peer sr-only" {{ in_array('event_updates', $prefs) ? 'checked' : '' }}>
                            <span class="absolute inset-0 rounded-full bg-slate-200 transition peer-checked:bg-primary-600"></span>
                            <span class="absolute left-0.5 h-5 w-5 rounded-full bg-white shadow transition peer-checked:translate-x-5"></span>
                        </span>
                    </label>

                    <label class="flex cursor-pointer items-center justify-between gap-4 py-3.5">
                        <span>
                            <span class="block text-sm font-medium text-slate-900">News and announcements</span>
                            <span class="block text-xs text-slate-500">Occasional updates from MyGovEvent</span>
                        </span>
                        <span class="relative inline-flex h-6 w-11 shrink-0 items-center">
                            <input type="checkbox" name="preferences[]" value="news_updates"
                                class="peer sr-only" {{ in_array('news_updates', $prefs) ? 'checked' : '' }}>
                            <span class="absolute inset-0 rounded-full bg-slate-200 transition peer-checked:bg-primary-600"></span>
                            <span class="absolute left-0.5 h-5 w-5 rounded-full bg-white shadow transition peer-checked:translate-x-5"></span>
                        </span>
                    </label>
                </div>

                <div class="border-t border-slate-100 px-6 py-4 sm:px-8">
                    <button type="submit" class="btn btn-primary">Save preferences</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Sidebar --}}
    <div class="space-y-8">
        {{-- Recent activity --}}
        <div class="card overflow-hidden">
            <div class="flex items-center gap-3 border-b border-slate-100 px-6 py-4">
                <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-emerald-50 text-emerald-700">
                    <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </span>
                <div>
                    <h2 class="text-base font-bold text-slate-900">Recent activity</h2>
                    <p class="text-xs text-slate-500">Your latest actions</p>
                </div>
            </div>

            @if ($activities->isEmpty())
                <p class="px-6 py-10 text-center text-sm text-slate-500">No activity yet.</p>
            @else
                <ul class="relative space-y-6 px-6 py-6">
                    <span class="absolute bottom-8 left-[22px] top-8 w-px bg-slate-200"></span>
                    @foreach ($activities as $activity)
                        <li class="relative flex items-start gap-3.5">
                            @if ($activity['type'] === 'event')
                                <span class="relative z-10 flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-indigo-50 text-indigo-700 ring-4 ring-white">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                    </svg>
                                </span>
                            @else
                                <span class="relative z-10 flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-primary-50 text-primary-700 ring-4 ring-white">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </span>
                            @endif
                            <div class="min-w-0 pt-0.5">
                                <p class="truncate text-sm font-semibold text-slate-900">{{ $activity['title'] }}</p>
                                <p class="text-xs text-slate-500 capitalize">{{ $activity['detail'] }}</p>
                                <p class="mt-0.5 text-xs text-slate-400">{{ $activity['time']->diffForHumans() }}</p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        {{-- Danger zone --}}
        <div class="overflow-hidden rounded-2xl border border-rose-200 bg-rose-50/50">
            <div class="flex items-center gap-3 border-b border-rose-200 px-6 py-4">
                <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-rose-100 text-rose-700">
                    <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                    </svg>
                </span>
                <div>
                    <h2 class="text-base font-bold text-rose-900">Danger zone</h2>
                    <p class="text-xs text-rose-600/80">Irreversible account actions</p>
                </div>
            </div>

            <div class="p-6">
                <p class="text-sm text-slate-600">
                    Deleting your account permanently removes your profile, registrations and certificates. This action cannot be undone.
                </p>
                <form method="POST" action="{{ route('profile.destroy') }}" class="mt-4"
                    onsubmit="return confirm('Are you sure you want to delete your account? This will permanently remove your profile, registrations and certificates and cannot be undone.');">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger w-full">Delete my account</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
