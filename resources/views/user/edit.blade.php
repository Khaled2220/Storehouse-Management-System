<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit User</title>

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
    @php
        $selectedUserType = (string) old(
            'user_type',
            $user->user_type->value
        );
    @endphp

    <div class="container">
        <h2 class="text-center">Edit User</h2>

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

            @can('update', $user)
                <form action="{{ route('user.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="full_name"> Full Name: </label>

                        <input type="text" name="full_name" id="full_name" class="form-control"
                            value="{{ old('full_name', $user->full_name) }}"
                            maxlength="250"
                            required>

                        @error('full_name')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">

                        <label for="email"> Email: </label>

                        <input type="email" name="email" id="email" class="form-control"
                            value="{{ old('email', $user->email) }}"
                            maxlength="225"
                            required>

                        @error('email')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">

                        <label for="password"> Password: </label>

                        <input type="password" name="password" id="password" class="form-control"
                            placeholder="Leave empty to keep current password"
                            minlength="7"
                            autocomplete="new-password">

                        @error('password')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="user_type"> User Type: </label>

                        <select name="user_type" id="user_type" class="form-control" required>

                            <option value="1" {{ $selectedUserType === '1' ? 'selected' : '' }}>
                                Admin
                            </option>

                            <option value="2" {{ $selectedUserType === '2' ? 'selected' : '' }}>
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
                        <button type="submit" class="btn btn-update">
                            Update User
                        </button>

                        <a href="{{ route('user.index') }}" class="btn btn-back">
                            Back
                        </a>
                    </div>
                </form>

            @else
                <div class="alert alert-danger">
                    You are not authorized to update this user.
                </div>

                <a href="{{ route('user.index') }}" class="btn btn-back">
                    Back
                </a>
            @endcan
        </div>
    </div>

