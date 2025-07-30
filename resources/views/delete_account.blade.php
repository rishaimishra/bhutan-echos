{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Your Account - Bhutan Echos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body { font-family: Arial, sans-serif; margin: 2em; background: #f9f9f9; }
        .container { background: #fff; padding: 2em; border-radius: 8px; max-width: 600px; margin: auto; }
        h1 { color: #333; }
        ul { margin-top: 1em; }
        .note { color: #b77c00; margin-top: 2em; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Delete Your Account</h1>
        <p>
            If you wish to delete your Bhutan Echoes account, please follow these steps:
        </p>
        <ol>
            <li>Please send email to vikrantsingh.slg@gmail.com with the reason why you want to delete your account from your registered email</li>
        </ol>
        <h2>What happens when you delete your account?</h2>
        <ul>
            <li>Your personal data and profile will be permanently deleted from our servers.</li>
            <li>Your activity history, posts, and any associated content will be removed.</li>
            <li>This action cannot be undone.</li>
        </ul>
        <h2>Data Retention</h2>
        <p>
            We do not retain any personal data after account deletion, except where required by law.
        </p>
        <div class="note">
            <strong>Need help?</strong> If you have trouble deleting your account, please contact our support at <a href="mailto:vikrantsingh.slg@gmail.com">producer@bhutanechoes.org</a>.
        </div>
    </div>
</body>
</html> --}}


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Your Account - Bhutan Echoes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 2em;
            background: #f3f4f6;
        }
        .container {
            background: #ffffff;
            padding: 2.5em;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            max-width: 600px;
            margin: auto;
        }
        h1, h2 {
            color: #222;
            margin-bottom: 0.5em;
        }
        p, li {
            color: #555;
            line-height: 1.6;
        }
        ul, ol {
            padding-left: 1.5em;
            margin-top: 1em;
        }
        .note {
            background: #fff8e1;
            border-left: 5px solid #ffc107;
            padding: 1em;
            margin-top: 2em;
            font-size: 0.95em;
        }
        a {
            color: #0077cc;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        form {
            margin-top: 1.5em;
            border-top: 1px solid #eee;
            padding-top: 1.5em;
        }
        .form-group {
            margin-bottom: 1.2em;
        }
        label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.5em;
            color: #333;
        }
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 0.75em;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 1em;
        }
        button {
            background-color: #d32f2f;
            color: white;
            border: none;
            padding: 0.75em 1.5em;
            border-radius: 6px;
            font-size: 1em;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #b71c1c;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Delete Your Account</h1>
        @if(session('success'))
            <div style="position: relative; padding: 1em; background-color: #e6f4ea; color: #2e7d32; border: 1px solid #c8e6c9; border-radius: 5px; margin-bottom: 1em;">
                <span style="position: absolute; top: 8px; right: 12px; cursor: pointer; font-weight: bold;" onclick="this.parentElement.style.display='none';">&times;</span>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div style="position: relative; padding: 1em; background-color: #fdecea; color: #c62828; border: 1px solid #f5c6cb; border-radius: 5px; margin-bottom: 1em;">
                <span style="position: absolute; top: 8px; right: 12px; cursor: pointer; font-weight: bold;" onclick="this.parentElement.style.display='none';">&times;</span>
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('account.delete') }}" onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">
    @csrf
    <div class="form-group">
        <label for="email">Registered Email Address</label>
        <input type="email" id="email" name="email" placeholder="you@example.com" required>
    </div>
    <div class="form-group">
        <label for="password">Account Password</label>
        <input type="password" id="password" name="password" placeholder="Enter your password" required>
    </div>
    <button type="submit">Request Account Deletion</button>
</form>


        {{-- <p>
            If you wish to delete your Bhutan Echoes account, please follow these steps:
        </p>
        <ol>
            <li>Please send an email to <a href="mailto:vikrantsingh.slg@gmail.com">vikrantsingh.slg@gmail.com</a> with the reason for deletion from your registered email.</li>
        </ol> --}}

        <h2>What happens when you delete your account?</h2>
        <ul>
            <li>Your personal data and profile will be permanently deleted from our servers.</li>
            <li>Your activity history, posts, and any associated content will be removed.</li>
            <li>This action cannot be undone.</li>
        </ul>

        <h2>Data Retention</h2>
        <p>
            We do not retain any personal data after account deletion, except where required by law.
        </p>

        <div class="note">
            <strong>Need help?</strong> If you have trouble deleting your account, please contact our support at 
            <a href="mailto:producer@bhutanechoes.org">producer@bhutanechoes.org</a>.
        </div>
    </div>
</body>
</html>
