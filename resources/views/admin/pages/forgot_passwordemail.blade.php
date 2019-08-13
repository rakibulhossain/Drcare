<!DOCTYPE html>
<html>
<head>
    <title>Welcome Email</title>
</head>

<body>
<h2>Welcome to the site {{$user['username']}}</h2>
<br/>
Your registered email-id is {{$user['email']}} , Please click on the below link to reset the password of your acount.
<br/>
<a href="{{url('password_reset', $user->id)}}">Verify Email</a>
</body>

</html>