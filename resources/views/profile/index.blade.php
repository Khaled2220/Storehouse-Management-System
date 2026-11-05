<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>My Profile</title>

    <link rel="stylesheet"
          href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <style>
        body {
            background-color: #f5f5f5;
        }

        .profile-container {
            max-width: 600px;
            margin: 50px auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        .profile-title {
            text-align: center;
            margin-bottom: 30px;
        }
        .profile-row {
            padding: 15px;
            border-bottom: 1px solid #eee;
        }

        .profile-label {
            font-weight: bold;
            color: #555;
        }
        .back-button {
            background-color: DimGrey;
            color: white;
            margin-top: 20px;
            width: 120px;
            height: 40px;
        }
        .back-button:hover,
        .back-button:focus {
            color: white;
            background-color: #444;
        }
        .edit-button {
            background-color: #f0ad4e;
            color: white;
            margin-top: 20px;
            width: 170px;
            height: 40px;
        }

        .edit-button:hover,
        .edit-button:focus {
            background-color: #ec971f;
            color: white;
        }

        .delete-button {
            background-color: #d9534f;
            color: white;
            width: 170px;
            height: 40px;
            margin-top: 10px;
        }

        .delete-button:hover,
        .delete-button:focus {
            background-color: #c9302c;
            color: white;
        }

        .delete-form {
            margin-top: 25px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="profile-container">
            <h2 class="profile-title">My Profile</h2>

            @if (session('status') === 'Profile-Updated-Successfully')
                <div class="alert alert-success">
                    Profile updated successfully.
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="profile-row">

                <div class="profile-label">Full Name</div>
                <div>{{ $user->full_name }}</div>

                <br>

                <div class="profile-label">Email</div>
                <div>{{ $user->email }}</div>

                <br>

                <div class="profile-label">User Type</div>
                <div>
                    {{ $user->isAdmin() ? 'Admin' : 'User' }}
                </div>
            </div>

            <a href="{{ route('profile.edit') }}" class="btn edit-button">
                Edit Profile
            </a>

            <a href="{{ route('products.index') }}" class="btn back-button">
                Back
            </a>

            <hr>

            <h4>Delete Account</h4>

            <p class="text-danger">
                Warning: Deleting your account is permanent.
            </p>

            <form action="{{ route('profile.destroy') }}" method="POST"
                class="delete-form"
                onsubmit="return confirm('Are you sure you want to delete your account?')"
            >
                @csrf
                @method('DELETE')

                <div class="form-group">

                    <label for="password"> Enter Your Current Password</label>

                    <input type="password" name="password" id="password"
                        class="form-control"
                        placeholder="Current Password"
                        autocomplete="current-password"
                        required
                    >

                    @error('password', 'userDeletion')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <button type="submit" class="btn delete-button">
                    <span class="glyphicon glyphicon-trash"></span>
                    Delete Account
                </button>
            </form>
        </div>
    </div>
