@extends('layouts.app')
@section('title', 'Agency Profile')

@section('content')
<div class="mx-auto max-w-2xl">
    <div class="card p-6 sm:p-8">
        <h1 class="text-xl font-bold tracking-tight text-slate-900">Edit agency</h1>
        <p class="mt-1 text-sm text-slate-500">Update the details for {{ $agency->agency_name }}.</p>

        <div class="mt-6">
            @include('agencies._form')
        </div>
    </div>
</div>
@endsection
