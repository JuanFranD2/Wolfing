<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fee Invoice</title>
</head>

<body
    style="font-family: Arial, sans-serif; line-height: 1.6; background-color: #f4f4f4; padding: 20px; text-align: center;">
    <div style="background-color: #ffffff; padding: 20px; border-radius: 5px; max-width: 600px; margin: auto;">
        <h1 style="color: #333;">Invoice #{{ $fee->id ?? 'N/A' }}</h1>
        <p style="font-size: 16px; color: #555;">
            Dear {{ $fee->client->name ?? 'Customer' }},
        </p>
        <p style="font-size: 16px; color: #555;">
            Please find attached your invoice for the amount of
            <strong>${{ number_format($fee->amount ?? 0, 2) }}</strong>.
        </p>
        <p style="font-size: 16px; color: #555;">Thank you for your business!</p>
    </div>
</body>

</html>
