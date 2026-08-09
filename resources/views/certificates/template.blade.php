<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; text-align: center; padding: 60px; }
        .border { border: 6px double #1e3a8a; padding: 50px; }
        h1 { color: #1e3a8a; font-size: 28px; margin-bottom: 4px; }
        .name { font-size: 24px; font-weight: bold; margin: 20px 0; }
        .details { font-size: 14px; color: #444; margin-top: 30px; }
    </style>
</head>
<body>
    <div class="border">
        <p style="letter-spacing: 3px; color: #666;">MYGOVEVENT — JABATAN DIGITAL NEGARA</p>
        <h1>Certificate of Participation</h1>
        <p>This is to certify that</p>
        <p class="name">{{ $registration->user->name }}</p>
        <p>has successfully attended</p>
        <p class="name" style="font-size: 18px;">{{ $registration->event->title }}</p>
        <div class="details">
            <p>Date: {{ $registration->event->date->format('d M Y') }} &nbsp;|&nbsp; Venue: {{ $registration->event->venue }}</p>
            <p>Organized by: {{ $registration->event->agency->agency_name ?? 'N/A' }}</p>
            <p>Certificate ID: MGE-{{ str_pad($registration->registration_id, 6, '0', STR_PAD_LEFT) }}</p>
        </div>
    </div>
</body>
</html>
