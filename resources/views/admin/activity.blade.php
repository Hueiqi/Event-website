@extends('layouts.app')
@section('title', 'System Activity')

@section('content')
<x-ui.page-header title="System activity log" subtitle="A record of significant events on the platform." />

<div class="card p-6">
    <div class="flex items-start gap-4">
        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-amber-50 text-amber-600">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
            </svg>
        </div>
        <div>
            <h2 class="text-base font-bold text-slate-900">Activity logging requires a database table</h2>
            <p class="mt-1 text-sm leading-relaxed text-slate-600">
                Activity logging (logins, registrations, event changes) requires an <code class="rounded bg-slate-100 px-1.5 py-0.5 text-xs text-slate-700">activity_log</code> table.
                Add the <code class="rounded bg-slate-100 px-1.5 py-0.5 text-xs text-slate-700">spatie/laravel-activitylog</code> package and it will populate here automatically.
            </p>
            <a href="https://spatie.be/docs/laravel-activitylog" target="_blank" rel="noopener" class="btn btn-secondary btn-sm mt-4">View documentation</a>
        </div>
    </div>
</div>
@endsection
