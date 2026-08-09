<!DOCTYPE html>
<html>
<body style="font-family: sans-serif; color: #222;">
    <h2 style="color: #1e3a8a;">Welcome to MyGovEvent</h2>
    <p>Hi {{ $user->name }},</p>
    <p>Thank you for registering. Please activate your account by clicking the button below:</p>
    <p>
        <a href="{{ $activationUrl }}"
           style="background:#1e3a8a;color:#fff;padding:10px 20px;text-decoration:none;border-radius:4px;">
            Activate My Account
        </a>
    </p>
    <p style="font-size: 12px; color: #666;">If the button doesn't work, copy this link: {{ $activationUrl }}</p>
    <p style="font-size: 12px; color: #666;">This link expires in 60 minutes.</p>
</body>
</html>
