<!DOCTYPE html>
<html>
<body style="font-family: sans-serif; color: #222;">
    <h2 style="color: #b91c1c;">Event Cancelled</h2>
    <p>We regret to inform you that the following event has been cancelled:</p>
    <p style="font-size: 18px; font-weight: bold;">{{ $event->title }}</p>
    <p>
        Originally scheduled for {{ $event->date->format('d M Y') }} at {{ $event->venue }}.
    </p>
    <p>We apologise for any inconvenience caused.</p>
</body>
</html>
