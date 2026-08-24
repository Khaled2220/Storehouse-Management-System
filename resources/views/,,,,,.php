<nav>
  <a hreef="{{ route('Products.index') }}">Products</a>
  <a href="{{ route('Categorios.index') }}">Categories</a>
</nav>

<h3>Category List</h3>

<table border="1">
  <tr>
    <th>Name</th>
    <th>Action</th>
  </tr>

  @foreach ($categories as $category)
  <tr>
    <td>{{ $category->name }}</td>

    <td>
      <form action="{{ url('/Categorios/'.$category->id) }}" method="POST" onsubmit="return confirm('Delete?')">
        @csrf
        @method('DELETE')
        <button style="color:red;">Delete</button>
      </form>
    </td>

  </tr>
  @endforeach
</table>

<br>

<a href="{{ route('Categorios.create') }}">
  <button>Add Category</button>
</a>


