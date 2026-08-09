@extends('layouts.app')
@section('title', 'Register Agency')

@section('content')
<div class="mx-auto max-w-2xl">
    <div class="card p-6 sm:p-8">
        <h1 class="text-xl font-bold tracking-tight text-slate-900">Register government agency</h1>
        <p class="mt-1 text-sm text-slate-500">Add a new government agency to the platform.</p>

        <div class="mt-6">
            @include('agencies._form')
        </div>
    </div>
</div>
@endsection
