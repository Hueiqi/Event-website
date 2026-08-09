<!DOCTYPE html>
<html>
<body style="font-family: sans-serif; color: #222;">
    <h2 style="color: #1e3a8a;">Registration Confirmed</h2>
    <p>Hi {{ $registration->user->name }},</p>
    <p>You are successfully registered for:</p>
    <p style="font-size: 18px; font-weight: bold;">{{ $registration->event->title }}</p>
    <p>
        Date: {{ $registration->event->date->format('d M Y') }}<br>
        Time: {{ $registration->event->time }}<br>
        Venue: {{ $registration->event->venue }}
    </p>
    <p>Your check-in QR code reference: <strong>{{ $registration->qr_code }}</strong></p>
    <p>Please present your attendance slip (available in your dashboard) at the venue for check-in.</p>
</body>
</html>
