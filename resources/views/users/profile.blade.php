@extends('layouts.app')
@section('title', 'My Profile')

@section('content')
<div class="mx-auto max-w-2xl">
    <div class="card overflow-hidden">
        <div class="flex items-center gap-4 bg-gradient-to-br from-primary-900 to-primary-950 px-6 py-8 sm:px-8">
            <span class="flex h-16 w-16 shrink-0 items-center justify-center rounded-full bg-white/15 text-2xl font-bold text-white ring-1 ring-white/25">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </span>
            <div class="min-w-0">
                <h1 class="text-xl font-bold text-white">{{ $user->name }}</h1>
                <p class="mt-0.5 flex flex-wrap items-center gap-2 text-sm text-primary-100">
                    <span>{{ $user->email }}</span>
                    <span class="h-1 w-1 rounded-full bg-primary-300"></span>
                    <span class="capitalize">{{ str_replace('_', ' ', $user->role) }}</span>
                </p>
            </div>
        </div>

        <form method="POST" action="{{ route('profile.update') }}" class="space-y-5 p-6 sm:p-8">
            @csrf @method('PUT')

            @if ($errors->any())
                <x-ui.alert type="danger" title="Please fix the following">
                    <ul class="mt-1 list-inside list-disc">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </x-ui.alert>
            @endif

            <div>
                <label class="label" for="name">Full name</label>
                <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required class="input">
            </div>

            <div>
                <label class="label" for="email">Email address</label>
                <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required class="input">
            </div>

            <div>
                <label class="label" for="mykad">MyKad / Passport No.</label>
                <input id="mykad" type="text" name="mykad" value="{{ old('mykad', $user->mykad) }}" placeholder="Optional" class="input">
            </div>

            <div>
                <label class="label" for="user_type">Account type</label>
                <input id="user_type" type="text" value="{{ ucfirst(str_replace('_', ' ', $user->user_type)) }}" disabled class="input bg-slate-100 text-slate-500">
            </div>

            <div class="flex gap-3 border-t border-slate-100 pt-5">
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </form>
    </div>
</div>
@endsection
