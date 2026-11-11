<head>
    <meta charset="UTF-8">
    <title>New Stock Movement</title>
</head>
<body>
    <h2>New Stock Movement Recorded</h2>

    <p>A new stock movement has been recorded in the Storehouse Management System.</p>

    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>Movement ID</th>
            <td>{{ $stockMovementId }}</td>
        </tr>

        <tr>
            <th>Product</th>
            <td>{{ $productName }}</td>
        </tr>

        <tr>
            <th>Movement Type</th>
            <td>{{ ucfirst($type) }}</td>
        </tr>

        <tr>
            <th>Quantity</th>
            <td>{{ $quantity }}</td>
        </tr>

        <tr>
            <th>Movement Date</th>
            <td>{{ $movementDate }}</td>
        </tr>
    </table>

    <p>Please check the system for more details.</p>

    <p>Storehouse Management System</p>
</body>
</html>