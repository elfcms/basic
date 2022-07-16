<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
</head>
<body>
    <h1>Email confirmation link:</h1>
    <a href="{{ route('user.confirm-email', ['email' => $user->email, 'token' => $user->confirm_token]) }}">{{ route('user.confirm-email', ['email' => $user->email, 'token' => $user->confirm_token]) }}</a>
</body>
</html>
