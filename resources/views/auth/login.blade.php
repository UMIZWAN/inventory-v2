<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
</head>

<body style="font-family: sans-serif; padding: 50px;">
    <h2>Login</h2>

    @if($errors->any())
        <p style="color: red;">{{ $errors->first() }}</p>
    @endif

    <form method="POST" action="/admin/login">
        @csrf

        <div>
            <label>Username</label><br>
            <input type="text" name="username">
        </div>
        <br>

        <div>
            <label>Password</label><br>
            <input type="password" name="password">
        </div>
        <br>

        <button type="submit">Login</button>
    </form>

</body>

</html>