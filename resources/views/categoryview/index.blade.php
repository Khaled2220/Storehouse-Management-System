<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<nav class="navbar navbar-expand-sm bg-primary navbar-dark">
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" style="color: black; font-size: 20px;" href="{{ route('Products.index') }}">Products</a>
    </li>

    <li class="nav-item">
      <a class="nav-link" style="color: black; font-size: 20px;" href="{{ route('Categorios.index') }}">Category</a>
    </li>

    <li class="nav-item">
      <a class="nav-link" style="color: black; font-size: 20px;" href="{{ route('notifications.index') }}">
        My Notifications
        @auth
          @php
            $unreadCount = auth()->user()->unreadNotifications()->count();
          @endphp

          @if ($unreadCount > 0)
            <span class="badge badge-light">{{ $unreadCount }}</span>
          @endif
        @endauth
      </a>
    </li>
  </ul>
</nav>

<br>

<div class="container">
  <h2>Categories List</h2>

  @if(session('success'))
    <div class="alert alert-success">
      {{ session('success') }}
    </div>
  @endif

  @if(session('error'))
    <div class="alert alert-danger">
      {{ session('error') }}
    </div>
  @endif

  @if(auth()->check() && auth()->user()->user_type === 1)
    <a href="{{ route('Categorios.create') }}">
      <button type="button" class="btn btn-success">Add New Category</button>
    </a>
  @endif

  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Name</th>
        @if(auth()->check() && auth()->user()->user_type === 1)
          <th>Action</th>
        @endif
      </tr>
    </thead>

    <tbody>
      @foreach($categorios as $category)
        <tr>
          <td>{{ $category->name }}</td>

          @if(auth()->check() && auth()->user()->user_type === 1)
            <td>
              <a href="{{ url('/Categorios/'.$category->id.'/edit') }}">
                <button type="button" class="btn btn-secondary btn-sm">Edit</button>
              </a>

              <form action="{{ url('/Categorios/'.$category->id) }}"
                    method="POST"
                    style="display:inline;"
                    onsubmit="return confirm('Are you sure?')">
                @csrf
                @method('DELETE')

                <button type="submit" class="btn btn-danger btn-sm">
                  <span class="glyphicon glyphicon-trash"></span> Delete
                </button>
              </form>
            </td>
          @endif
        </tr>
      @endforeach
    </tbody>
  </table>

  <br>

  <a href="{{ route('Products.index') }}" style="background-color: DimGrey; color: white; padding: 8px 16px; text-decoration: none; border-radius: 4px; font-weight: bold;">Back</a>
</div>
