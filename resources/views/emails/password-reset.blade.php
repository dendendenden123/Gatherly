<!DOCTYPE html>
<html>
<head>
    <title>Password Reset</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4F46E5;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin: 20px 0;
        }
        .button:hover {
            background-color: #4338CA;
        }
    </style>
</head>
<body>
    <h2>Password Reset Request</h2>
    <p>You are receiving this email because we received a password reset request for your account.</p>
    <a href="{{ $url }}" class="button">Reset Password</a>
    <p>This password reset link will expire in 60 minutes.</p>
    <p>If you did not request a password reset, no further action is required.</p>
    <p>Thanks,<br>Gatherly Team</p>
</body>
</html>
