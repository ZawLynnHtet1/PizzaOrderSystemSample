<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Page</title>
</head>
<body>
    <h4>Admin Page</h4>
    <form action="{{route('logout')}}" method="POST">
        @csrf
        <input type="submit" name="submitBtn" value="Logout">
    </form>
</body>
</html>
