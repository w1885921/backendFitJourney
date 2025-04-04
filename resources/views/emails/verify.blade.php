<!DOCTYPE html>
<html>
<head>
    <title>Email Verification</title>
</head>
<body>
    <h2>Hello {{ $user->name }},</h2>
    <p>Your verification code is: <strong>{{ $verificationCode }}</strong></p>
    <p>Enter this code in the app to verify your email.</p>
</body>
</html>
