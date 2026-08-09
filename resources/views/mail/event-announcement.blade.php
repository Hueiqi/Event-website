<!DOCTYPE html>
<html>
<body style="font-family: sans-serif; color: #222;">
    <h2 style="color: #1e3a8a;">Announcement: {{ $event->title }}</h2>
    <p>{{ $message }}</p>
    <hr>
    <p style="font-size: 12px; color: #666;">
        Sent by the organizer of {{ $event->title }} via MyGovEvent.
    </p>
</body>
</html>
