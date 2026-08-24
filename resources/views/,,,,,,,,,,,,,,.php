<nav>
 <a href="{{ route('products.index') }}">Products</a>
    <a href="{{ route('categories.index') }}">Categories</a>
</nav>



<h4>Add New Product</h4>
@if(session('success'))
    <div>
        ✓ {{ session('success') }}
    </div>
@endif


<h5>Products List</h5>
<div>
   <table border="1">
      <tr>
        <th>Name</th>
        <th>Description</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Image</th>   
        <th>Action</th>
      </tr>
      @foreach($products as $product)
      <tr>   
        <td>{{$product->name}}</td>
        <td>{{$product->description}}</td>
        <td>{{$product->quantity}}</td>
        <td>{{$product->price}}</td>
        <td><img src="{{ asset('image/' . $product->image) }}" width="60" height="auto" alt="product"></td>
        <td>
               <a href="{{ url('/products/'.$product->id.'/edit') }}">
                  <button type="button">Edit Quantity</button>
             </a>
             <form action="{{ url('/products/'.$product->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure?')">                         
                  @csrf
                  @method('DELETE') 
                  <button type="submit">Delete Product</button>
             </form>
        </td>     
      </tr>
      @endforeach
   </table>
</div>

<div>
    <a href="{{ route('products.create') }}">
        <button type="button">Add New Product</button>
    </a>
</div>