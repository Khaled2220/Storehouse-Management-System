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
      <a class="nav-link" href="{{ route('Products.index') }}">Products</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('Categorios.index') }}">Category</a>
    </li>
   
  </ul>
</nav>
<br>

<div class="container">
@if(auth()->check() && auth()->user()->user_type === 1)
    <h2>Edit Product</h2>
   @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li style="color:red;">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


<form method="POST" action="{{ url('/Products/'.$product->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <label>Name:</label><br>
    <input type="text" name="name" value="{{ $product->name }}" required><br><br>

    <label>Description:</label><br>
    <textarea name="description">{{ $product->description }}</textarea><br><br>

    <label>Quantity:</label><br>
    <input type="number" name="quantity" value="{{ $product->quantity }}" min="1" required><br><br>

    <label>Price:</label><br>
    <input type="number" name="price" value="{{ $product->price }}" min="1" required><br><br>

    <label>Current Image:</label><br>
    @if($product->image)
        <img src="{{ asset('image/' . $product->image) }}" width="80"><br><br>
    @endif

    <label>Change Image:</label><br>
    <input type="file" name="image"><br><br>

      <button type="submit" 
        class="btn btn-sm text-white fw-bold shadow-sm" 
        style="background-color: Green; padding: 2px 6px; font-size: 11px;">
  Update Product
</button>
</form>

<br>

<a href="{{ route('Products.index') }}" style="background-color: DimGrey; color: white; padding: 8px 16px; text-decoration: none; border-radius: 4px; font-weight: bold;">Back</a>

@else
    <div class="alert alert-danger" style="margin-top: 20px;">
        <h4>Unauthorized access! Admin only.</h4>
        <p>Redirecting you back to the products list...</p>
    </div>
    <script>
        setTimeout(function() {
            window.location.href = "{{ route('Products.index') }}";
        }, 2000);
     </script> 
@endif 
</div>    