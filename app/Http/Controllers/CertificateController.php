<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Support\Facades\Auth;

class CertificateController extends Controller
{
    public function generate(Registration $registration)
    {
        if ($registration->user_id !== Auth::id()) {
            abort(403);
        }

        if ($registration->status !== 'attended') {
            return back()->with('error', 'Certificate is only available after attendance has been verified.');
        }

        $registration->update(['certificate_generated' => true]);

        // Generate PDF via barryvdh/laravel-dompdf or similar
        // composer require barryvdh/laravel-dompdf
        $pdf = app('dompdf.wrapper')->loadView('certificates.template', [
            'registration' => $registration->load(['user', 'event']),
        ]);

        return $pdf->download('certificate-' . $registration->registration_id . '.pdf');
    }
}
