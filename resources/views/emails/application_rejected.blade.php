<!DOCTYPE html>
<html>
<head>
    <title>Application Rejected</title>
</head>
<body>
    <h1>Hello, {{ $user->first_name }} {{ $user->last_name }}!</h1>
    <p>Thank you for waiting, unfortunately we would like to inform that your application has been rejected</p>
    <p><b>Business Name: </b>{{ $application->business_name}}</p>
    <p><b>Business Description: </b>{{ $application->business_description }}</p>
</body>
</html>
