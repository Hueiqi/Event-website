@props([
    'type' => 'info',
])

@php
    $styles = [
        'info' => 'bg-primary-50 text-primary-800 ring-1 ring-inset ring-primary-200',
        'success' => 'bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-200',
        'warning' => 'bg-amber-50 text-amber-700 ring-1 ring-inset ring-amber-200',
        'danger' => 'bg-rose-50 text-rose-700 ring-1 ring-inset ring-rose-200',
        'neutral' => 'bg-slate-100 text-slate-600 ring-1 ring-inset ring-slate-200',
    ];
@endphp

<span {{ $attributes->merge(['class' => 'badge ' . $styles[$type]]) }}>
    {{ $slot }}
</span>
