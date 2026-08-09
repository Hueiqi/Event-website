@props([
    'label' => null,
    'error' => null,
])

<div {{ $attributes->only('class') }}>
    @if ($label)
        <label class="label">{{ $label }}</label>
    @endif
    <div class="relative">
        {{ $slot }}
    </div>
    @if ($error)
        <p class="mt-1.5 text-sm text-rose-600">{{ $error }}</p>
    @elseif (isset($hint))
        <p class="mt-1.5 text-xs text-slate-400">{{ $hint }}</p>
    @endif
</div>
