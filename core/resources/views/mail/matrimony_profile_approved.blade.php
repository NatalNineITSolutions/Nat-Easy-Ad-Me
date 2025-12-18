<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Profile Approved</title>
</head>
<body>
    <h2>Hello {{ $profile->name }}, 👋</h2>

    <p>
        We’re happy to inform you that your matrimony profile has been
        <strong>successfully approved</strong>.
    </p>

    <h4>Your Profile Details</h4>
    <ul>
        <li><strong>Name:</strong> {{ $profile->name }}</li>
        <li><strong>Email:</strong> {{ $profile->email }}</li>
        <li><strong>Profile ID:</strong> {{ $profile->id }}</li>
        <li><strong>Status:</strong> Approved</li>
    </ul>

    <p>You can now log in and start exploring matches.</p>

    <p>
        <a href="{{ url('/login') }}">Login to Your Account</a>
    </p>

    <br>
    <p>
        Regards,<br>
        <strong>Matrimony Team</strong>
    </p>
</body>
</html>
