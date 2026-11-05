<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add User</title>

    <link rel="stylesheet"
          href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <style>
        body {
            padding: 30px;
            background-color: #f5f5f5;
        }
        .form-container {
            max-width: 600px;
            margin: 30px auto;
            padding: 30px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        .btn-add {
            background-color: #5cb85c;
            color: white;
            width: 170px;
            height: 40px;
        }
        .btn-add:hover,
        .btn-add:focus {
            background-color: #449d44;
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
        <h2 class="text-center">Add New User</h2>

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

            @can('create', \App\Models\User::class)
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="full_name"> Full Name: </label>

                        <input type="text" name="full_name" id="full_name" class="form-control" value="{{ old('full_name') }}" placeholder="Enter full name" maxlength="250" required>

                        @error('full_name')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email"> Email: </label>

                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" placeholder="Enter email" maxlength="225" required>

                        @error('email')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password"> Password: </label>

                        <input type="password" name="password" id="password" class="form-control" placeholder="Enter password" minlength="7" required>

                        @error('password')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="user_type"> User Type: </label>

                        <select name="user_type" id="user_type" class="form-control" required>

                            <option value=""> Select User Type </option>

                            <option value="1" {{ old('user_type') === '1' ? 'selected' : '' }}>
                                Admin
                            </option>

                            <option value="2" {{ old('user_type') === '2' ? 'selected' : '' }}>
                                User
                            </option>
                        </select>

                        @error('user_type')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-add">
                            Add User
                        </button>

                        <a href="{{ route('users.index') }}" class="btn btn-back">
                            Back
                        </a>
                    </div>
                </form>

            @else
                <div class="alert alert-danger">
                    You are not authorized to create users.
                </div>

                <a href="{{ route('users.index') }}" class="btn btn-back">
                    Back
                </a>
            @endcan
        </div>
    </div>

