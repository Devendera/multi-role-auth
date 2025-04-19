<!DOCTYPE html>
<html>
<head>
    <title>Multi Role Login</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <h2>Login</h2>

    @if($errors->any())
        <div style="color:red;">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('login.submit') }}">
        @csrf
        <label>Email:</label>
        <input type="email" name="email" required><br><br>

        <label>Password:</label>
        <input type="password" name="password" required><br><br>

        <button type="submit">Login</button>
    </form>
</body>
</html>
