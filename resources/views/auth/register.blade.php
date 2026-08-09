@extends('layouts.app')
@section('title', 'Create account')

@section('content')
<div class="mx-auto max-w-lg">
    <div class="card overflow-hidden">
        <div class="bg-gradient-to-br from-primary-900 to-primary-950 px-6 py-8 text-center">
            <span class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-white/15 text-white ring-1 ring-white/25">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM3 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 019.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
                </svg>
            </span>
            <h1 class="mt-4 text-xl font-bold text-white">Create your account</h1>
            <p class="mt-1 text-sm text-primary-100">Register to attend government events</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-4 p-6 sm:p-8">
            @csrf

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
                <input id="name" type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. Ahmad bin Ali" class="input">
            </div>

            <div>
                <label class="label" for="email">Email address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required placeholder="you@example.com" class="input">
            </div>

            <div>
                <label class="label" for="user_type">User category</label>
                <select id="user_type" name="user_type" required class="input">
                    <option value="government" @selected(old('user_type') === 'government')>Government Servant</option>
                    <option value="educational" @selected(old('user_type') === 'educational')>Government Educational Institution</option>
                    <option value="private" @selected(old('user_type') === 'private')>Private Educational Institution</option>
                    <option value="politician" @selected(old('user_type') === 'politician')>Politician</option>
                    <option value="international" @selected(old('user_type') === 'international')>International</option>
                    <option value="public" @selected(old('user_type') === 'public')>Public / Citizen</option>
                </select>
            </div>

            <div>
                <label class="label" for="mykad">MyKad / Passport No.</label>
                <input id="mykad" type="text" name="mykad" value="{{ old('mykad') }}" placeholder="Optional" class="input">
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label class="label" for="password">Password</label>
                    <input id="password" type="password" name="password" required placeholder="••••••••" class="input">
                </div>
                <div>
                    <label class="label" for="password_confirmation">Confirm password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required placeholder="••••••••" class="input">
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-full">Create account</button>
        </form>

        <div class="border-t border-slate-100 bg-slate-50 px-6 py-4 text-center text-sm text-slate-600">
            Already have an account?
            <a href="{{ route('login') }}" class="font-semibold text-primary-700 hover:underline">Sign in</a>
        </div>
    </div>
</div>
@endsection
