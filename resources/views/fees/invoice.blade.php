<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fee Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            width: 80%;
            margin: 30px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #4CAF50;
            font-size: 36px;
            margin-bottom: 20px;
        }

        .invoice-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .invoice-header h2 {
            margin: 0;
            font-size: 28px;
            color: #555;
        }

        .invoice-header p {
            margin: 5px 0;
            font-size: 16px;
            color: #777;
        }

        .invoice-details {
            margin-top: 30px;
            border-top: 2px solid #4CAF50;
            padding-top: 20px;
        }

        .invoice-details table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .invoice-details th,
        .invoice-details td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .invoice-details th {
            background-color: #f4f4f4;
            color: #333;
            font-size: 16px;
        }

        .invoice-details td {
            font-size: 14px;
            color: #555;
        }

        .total {
            text-align: right;
            font-size: 18px;
            font-weight: bold;
            margin-top: 20px;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            color: #777;
            font-size: 14px;
        }

        .footer p {
            margin: 5px 0;
        }

        .footer a {
            color: #4CAF50;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="invoice-header">
            <h1>Invoice</h1>
            <h2>Fee Invoice</h2>
            <p>Date: {{ \Carbon\Carbon::parse($fee->issue_date)->format('Y-m-d') }}</p>
        </div>

        <div class="invoice-details">
            <table>
                <tr>
                    <th>Client Name</th>
                    <td>{{ $fee->client->name }}</td>
                </tr>
                <tr>
                    <th>Concept</th>
                    <td>{{ $fee->concept }}</td>
                </tr>
                <tr>
                    <th>Amount</th>
                    <td>{{ $fee->amount }} €</td>
                </tr>
                @if (isset($convertedAmount) && isset($currency))
                    <tr>
                        <th>Converted Amount</th>
                        <td>{{ $convertedAmount }} {{ $currency }}</td>
                    </tr>
                @endif
                <tr>
                    <th>Issue Date</th>
                    <td>{{ \Carbon\Carbon::parse($fee->issue_date)->format('Y-m-d') }}</td>
                </tr>
                <tr>
                    <th>Notes</th>
                    <td>{{ $fee->notes }}</td>
                </tr>
            </table>

            <div class="total">
                <p>Total: {{ isset($convertedAmount) ? $convertedAmount . ' ' . $currency : $fee->amount . ' €' }}</p>
            </div>
        </div>

        <div class="footer">
            <p>Thank you for doing business with us!</p>
            <p>If you have any questions, feel free to <a href="mailto:wolfing@jijecae.eh">contact us</a>.</p>
        </div>
    </div>
</body>

</html>
