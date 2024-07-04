<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Flight Reminder</title>
</head>

<body>
    <p>Dear {{ $passenger->name }},</p>

    <p>This is a reminder that your flight {{ $flight->number }} is scheduled to depart on
        {{ $flight->departure_time->format('Y-m-d H:i') }}.</p>

    <p>Please make sure to arrive at the airport at least 2 hours before the scheduled departure time.</p>

    <p>Thank you,<br>
        Flight Booking Team</p>
</body>

</html>
