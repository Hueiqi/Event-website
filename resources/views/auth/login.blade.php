@extends('layouts.app')
@section('title', 'Sign in')

@section('content')
<div class="mx-auto max-w-md">
    <div class="card overflow-hidden">
        <div class="bg-gradient-to-br from-primary-900 to-primary-950 px-6 py-8 text-center">
            <span class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-white/15 text-white ring-1 ring-white/25">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                </svg>
            </span>
            <h1 class="mt-4 text-xl font-bold text-white">Welcome back</h1>
            <p class="mt-1 text-sm text-primary-100">Sign in to your MyGovEvent account</p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-4 p-6 sm:p-8">
            @csrf

            @if ($errors->any())
                <x-ui.alert type="danger" title="Login failed">{{ $errors->first() }}</x-ui.alert>
            @endif

            <div>
                <label class="label" for="email">Email address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                       placeholder="you@example.gov.my" class="input">
            </div>

            <div>
                <label class="label" for="password">Password</label>
                <input id="password" type="password" name="password" required placeholder="••••••••" class="input">
            </div>

            <label class="flex items-center gap-2 text-sm text-slate-600">
                <input type="checkbox" name="remember" class="h-4 w-4 rounded border-slate-300 text-primary-600 focus:ring-primary-500">
                Remember me
            </label>

            <button type="submit" class="btn btn-primary w-full">Sign in</button>
        </form>

        <div class="border-t border-slate-100 bg-slate-50 px-6 py-4 text-center text-sm text-slate-600">
            New to MyGovEvent?
            <a href="{{ route('register') }}" class="font-semibold text-primary-700 hover:underline">Create an account</a>
        </div>
    </div>
</div>
@endsection
