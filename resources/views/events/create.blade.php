@extends('layouts.app')
@section('title', 'Create Event')

@section('content')
<div class="mx-auto max-w-3xl">
    <div class="card p-6 sm:p-8">
        <h1 class="text-xl font-bold tracking-tight text-slate-900">Create new event</h1>
        <p class="mt-1 text-sm text-slate-500">Fill in the details below to publish a new government event.</p>

        <div class="mt-6">
            @include('events._form')
        </div>
    </div>
</div>
@endsection
