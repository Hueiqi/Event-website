@extends('layouts.app')
@section('title', 'Attendance Slip')

@section('content')
<div class="mx-auto max-w-md">
    <div class="card overflow-hidden text-center">
        <div class="bg-gradient-to-br from-primary-900 to-primary-950 px-6 py-7">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-primary-200">MyGovEvent Digital Attendance Slip</p>
        </div>

        <div class="p-6 sm:p-8">
            <h1 class="text-xl font-bold text-slate-900">{{ $registration->event->title }}</h1>
            <p class="mt-1 text-sm text-slate-500">
                {{ \Carbon\Carbon::parse($registration->event->date)->format('l, d F Y') }} · {{ $registration->event->venue }}
            </p>

            <div class="my-6 flex justify-center">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ urlencode($registration->qr_code) }}"
                     alt="Attendance QR code" class="rounded-xl border-2 border-slate-100 p-2">
            </div>

            <div class="space-y-1 rounded-xl bg-slate-50 px-4 py-4 text-sm">
                <p class="flex justify-between gap-4">
                    <span class="text-slate-500">Name</span>
                    <span class="font-semibold text-slate-900">{{ $registration->user->name }}</span>
                </p>
                <p class="flex justify-between gap-4">
                    <span class="text-slate-500">Reference</span>
                    <span class="font-mono font-semibold text-slate-900">{{ $registration->qr_code }}</span>
                </p>
            </div>

            <div class="mt-5">
                @if ($registration->checked_in)
                    <span class="inline-flex items-center gap-2 rounded-full bg-emerald-50 px-4 py-2 text-sm font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-200">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Checked in on {{ \Carbon\Carbon::parse($registration->checked_in_at)->format('d M Y, H:i') }}
                    </span>
                @else
                    <span class="inline-flex items-center gap-2 rounded-full bg-amber-50 px-4 py-2 text-sm font-semibold text-amber-700 ring-1 ring-inset ring-amber-200">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Not yet checked in — present this QR code at the venue
                    </span>
                @endif
            </div>
        </div>
    </div>

    <div class="mt-4 text-center">
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">Back to dashboard</a>
    </div>
</div>
@endsection
