head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Category Products</title>

    <link rel="stylesheet"
          href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <style>
        .container {
            margin-top: 30px;
        }
        .table th,
        .table td {
            text-align: center;
            vertical-align: middle !important;
        }
        .back-btn {
            background-color: DimGrey;
            color: white;
            width: 170px;
            height: 40px;
        }
        .back-btn:hover {
            background-color: #555;
            color: white;
        }
        .product-image {
            width: 70px;
            height: 70px;
            object-fit: cover;
        }
    </style>
</head>

<body>
<div class="container">
    <h2>Category: {{ $category->name }}</h2>
    <h3>Products List</h3>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Image</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($category->products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->quantity }}</td>
                        <td>{{ $product->price }}</td>

                        <td>
                            @if ($product->image)
                                <img
                                    src="{{ asset('image/' . $product->image) }}"
                                    alt="{{ $product->name }}"
                                    class="product-image">
                            @else
                                No Image
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">
                            No products found in this category.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <a href="{{ route('Categorios.index') }}" class="btn back-btn">
        Back to Categories
    </a>
</div>
