<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>User Details</title>

    <link rel="stylesheet"
          href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <style>
        body {
            padding: 30px;
            background-color: #f5f5f5;
        }
        .details {
            width: 60%;
            margin: 30px auto;
            background-color: white;
        }
        .details th {
            width: 30%;
        }
        .btn-back {
            background-color: DimGrey;
            color: white;
            width: 120px;
            height: 40px;
        }
        .btn-back:hover,
        .btn-back:focus {
            background-color: #444;
            color: white;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 class="text-center">User Details</h2>

        <table class="table table-bordered details">
            <tr>
                <th>ID</th>
                <td>{{ $user->id }}</td>
            </tr>

            <tr>
                <th>Full Name</th>
                <td>{{ $user->full_name }}</td>
            </tr>

            <tr>
                <th>Email</th>
                <td>{{ $user->email }}</td>
            </tr>

            <tr>
                <th>User Type</th>
                <td>
                    {{ $user->isAdmin() ? 'Admin' : 'User' }}
                </td>
            </tr>

            <tr>
                <th>Created At</th>
                <td>
                    {{ $user->created_at?->format('Y-m-d H:i:s') }}
                </td>
            </tr>

            <tr>
                <th>Updated At</th>
                <td>
                    {{ $user->updated_at?->format('Y-m-d H:i:s') }}
                </td>
            </tr>
        </table>

        <div class="text-center">
            <a href="{{ route('users.index') }}" class="btn btn-back">
                Back
            </a>
        </div>
    </div>

