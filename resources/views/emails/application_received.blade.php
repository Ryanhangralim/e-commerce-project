<!DOCTYPE html>
<html>
<head>
    <title>Application Received</title>
</head>
<body>
    <h1>Hello, {{ $user->first_name }} {{ $user->last_name }}!</h1>
    <p>Thank you for applying to be a seller on our platform. Your application is currently under review.</p>
    <p><b>Business Name: </b>{{ $application->business_name}}</p>
    <p><b>Business Description: </b>{{ $application->business_description }}</p>
    <p>We will notify you once your application status is updated.</p>
</body>
</html>
