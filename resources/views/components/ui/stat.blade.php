@props([
    'icon' => null,
    'label' => null,
    'value' => null,
    'tone' => 'primary',
])

@php
    $tones = [
        'primary' => 'bg-primary-50 text-primary-700',
        'emerald' => 'bg-emerald-50 text-emerald-700',
        'amber' => 'bg-amber-50 text-amber-700',
        'rose' => 'bg-rose-50 text-rose-700',
        'indigo' => 'bg-indigo-50 text-indigo-700',
    ];
@endphp

<div {{ $attributes->merge(['class' => 'card flex items-center gap-4 p-5']) }}>
    @if ($icon)
        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl {{ $tones[$tone] }}">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icon }}" />
            </svg>
        </div>
    @endif
    <div>
        <p class="text-2xl font-bold tracking-tight text-slate-900">{{ $value }}</p>
        <p class="text-sm text-slate-500">{{ $label }}</p>
    </div>
</div>
