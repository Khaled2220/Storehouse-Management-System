<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Users List</title>

    <link rel="stylesheet"
          href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <style>
        body {
            padding: 30px;
            background-color: #f5f5f5;
        }
        h2 {
            margin-bottom: 25px;
        }
        .btn {
            width: 100px;
            margin: 2px;
        }
        .btn-show {
            background-color: DimGrey;
            color: white;
        }
        .btn-show:hover,
        .btn-show:focus {
            background-color: #555555;
            color: white;
        }
        .btn-edit {
            background-color: #f0ad4e;
            color: white;
        }
        .btn-edit:hover,
        .btn-edit:focus {
            background-color: #ec971f;
            color: white;
        }
        .btn-delete {
            background-color: #d9534f;
            color: white;
            border: none;
        }
        .btn-delete:hover,
        .btn-delete:focus {
            background-color: #c9302c;
            color: white;
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
        .table {
            background-color: white;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Users List</h2>

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

        @can('create', \App\Models\User::class)
            <a href="{{ route('user.create') }}" class="btn btn-add">
                Add User
            </a>
        @endcan

        <br><br>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>User Type</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>
                            {{ $user->id }}
                        </td>

                        <td>
                            {{ $user->full_name }}
                        </td>

                        <td>
                            {{ $user->email }}
                        </td>

                        <td>
                            {{ $user->isAdmin() ? 'Admin' : 'User' }}
                        </td>

                        <td>
                            {{ $user->created_at?->format('Y-m-d') }}
                        </td>

                        <td>
                            @can('view', $user)
                                <a href="{{ route('user.show', $user->id) }}" class="btn btn-show">
                                    Show
                                </a>
                            @endcan

                            @can('update', $user)
                                <a href="{{ route('user.edit', $user->id) }}" class="btn btn-edit">
                                    Edit
                                </a>
                            @endcan

                            @can('delete', $user)
                                <form action="{{ route('user.destroy', $user->id) }}"
                                    method="POST"
                                    style="display: inline;"
                                    onsubmit="return confirm('Are you sure you want to delete this user?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-delete">
                                        Delete
                                    </button>
                                </form>
                            @endcan
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="6" class="text-center">
                            No Users Found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="text-center">
            {{ $users->links() }}
        </div>
    </div>
