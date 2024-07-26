<!DOCTYPE html>
<html>
<head>
    <title>Application Approved</title>
</head>
<body>
    <h1>Hello, {{ $user->first_name }} {{ $user->last_name }}!</h1>
    <p>Thank you for waiting, we would like to inform that your application has been approved!</p>
    <p><b>Business Name: </b>{{ $application->business_name}}</p>
    <p><b>Business Description: </b>{{ $application->business_description }}</p>
    <p>You are now a seller and is able to start selling things!</p>
</body>
</html>
