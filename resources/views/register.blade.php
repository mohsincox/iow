<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Register</title>
</head>
<body>

<form action="{{ route('signup') }}" method="POST">
    @csrf
    <input type="text" name="name" placeholder="User Name">
    <input type="number" name="phone" placeholder="User Phone">
    <input type="email" name="email" placeholder="User email">
    <input type="password" name="password" placeholder="Password">
    <input type="password" name="confirm_password" placeholder="Confirm Password">
    <input type="submit" name="Submit">
</form>
</body>
</html>
