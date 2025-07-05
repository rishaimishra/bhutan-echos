<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Password Reset - Bhutan Echos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #4a90e2;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background-color: #f9f9f9;
            padding: 30px;
            border-radius: 0 0 5px 5px;
        }
        .button {
            display: inline-block;
            background-color: #4a90e2;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Bhutan Echos</h1>
        <h2>Password Reset Request</h2>
    </div>
    
    <div class="content">
        <p>Hello {{ $name }},</p>
        
        <p>We received a request to reset your password for your Bhutan Echos account.</p>
        
        <p>If you made this request, please click the button below to reset your password:</p>
        
        <div style="text-align: center;">
            <a href="{{ $resetLink }}" class="button">Reset Password</a>
        </div>
        
        <p>If you didn't request a password reset, you can safely ignore this email.</p>
        
        <p><strong>Important:</strong></p>
        <ul>
            <li>This link will expire in 24 hours</li>
            <li>If the button doesn't work, copy and paste this link into your browser: {{ $resetLink }}</li>
        </ul>
        
        <p>If you have any questions, please contact our support team.</p>
        
        <p>Best regards,<br>
        The Bhutan Echos Team</p>
    </div>
    
    <div class="footer">
        <p>This email was sent to {{ $email }}</p>
        <p>&copy; {{ date('Y') }} Bhutan Echos. All rights reserved.</p>
    </div>
</body>
</html> 