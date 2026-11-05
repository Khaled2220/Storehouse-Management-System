<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Profile</title>

    <link rel="stylesheet"
          href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <style>
        body {
            background-color: #f5f5f5;
            padding: 30px;
        }
        .form-container {
            max-width: 600px;
            margin: 30px auto;
            padding: 30px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-update {
            background-color: #f0ad4e;
            color: white;
            width: 170px;
            height: 40px;
        }
        .btn-update:hover,
        .btn-update:focus {
            background-color: #ec971f;
            color: white;
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

        .form-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 class="text-center">Edit Profile</h2>

        <div class="form-container">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('status') === 'Profile-Updated-Successfully')
                <div class="alert alert-success">
                    Profile updated successfully.
                </div>
            @endif

            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="form-group">
                    <label for="full_name">Full Name:</label>

                    <input type="text" name="full_name" id="full_name"
                        class="form-control" value="{{ old('full_name', $user->full_name) }}"
                        autocomplete="name"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>

                    <input type="email" name="email" id="email"
                        class="form-control"
                        value="{{ old('email', $user->email) }}"
                        autocomplete="email"
                        required
                    >
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-update">
                        Update Profile
                    </button>

                    <a href="{{ route('profile') }}" class="btn btn-back">
                        Back
                    </a>
                </div>
            </form>
        </div>
    </div>

