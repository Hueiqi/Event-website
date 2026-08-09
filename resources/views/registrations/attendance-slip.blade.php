@extends('layouts.app')
@section('title', 'Attendance Slip')

@section('content')
<style>
    @media print {
        header, footer, .no-print { display: none !important; }
        main { padding: 0 !important; }
        body { background: #fff !important; }
        .print-area { box-shadow: none !important; border: none !important; border-radius: 0 !important; }
    }
</style>

<div class="mx-auto max-w-md">
    {{-- Action buttons --}}
    <div class="no-print mb-4 flex flex-wrap items-center justify-between gap-2">
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h11.25M3.75 3l9 9m-4.5 8.25L15.75 6" />
            </svg>
            Back to dashboard
        </a>
        <button type="button" onclick="window.print()" class="btn btn-primary">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659" />
            </svg>
            Print / Save PDF
        </button>
    </div>

    <div class="card overflow-hidden text-center print-area">
        <div class="bg-gradient-to-br from-primary-900 to-primary-950 px-6 py-7">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-primary-200">MyGovEvent Digital Attendance Slip</p>
        </div>

        <div class="p-6 sm:p-8">
            <h1 class="text-xl font-bold text-slate-900">{{ $registration->event->title }}</h1>
            <p class="mt-1.5 text-sm font-medium text-slate-600">
                {{ \Carbon\Carbon::parse($registration->event->date)->format('l, d F Y') }}
                · {{ \Carbon\Carbon::parse($registration->event->time)->format('h:i A') }}
                · {{ $registration->event->venue }}
            </p>

            <div class="my-6 flex justify-center">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ urlencode($registration->qr_code) }}"
                     alt="Attendance QR code" class="rounded-xl border-2 border-slate-100 p-2">
            </div>

            {{-- Participant details --}}
            <dl class="space-y-4 rounded-xl bg-slate-50 px-5 py-5 text-left">
                <div>
                    <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Name</dt>
                    <dd class="mt-1 text-sm font-semibold text-slate-900">{{ $registration->user->name }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">Reference</dt>
                    <dd class="mt-1 break-all font-mono text-xs font-medium text-slate-700">{{ $registration->qr_code }}</dd>
                </div>
            </dl>

            <div class="mt-5">
                @if ($registration->checked_in)
                    <span class="inline-flex items-center gap-2 rounded-full bg-emerald-50 px-4 py-2 text-sm font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-200">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Checked in on {{ \Carbon\Carbon::parse($registration->checked_in_at)->format('d M Y, H:i') }}
                    </span>
                @else
                    <span class="inline-flex items-center gap-2 rounded-full bg-amber-50 px-4 py-2 text-sm font-semibold text-amber-800 ring-1 ring-inset ring-amber-300">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Not yet checked in — present this QR code at the venue
                    </span>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
