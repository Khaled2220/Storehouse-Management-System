@extends('layouts.app')

@section('title', 'Categories List')

@section('content')

    <h2>Categories List</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @can('create', \App\Models\Category::class)
        <div class="add-button">
            <a href="{{ route('categories.create') }}" class="btn add-btn">
                Add New Category
            </a>
        </div>
    @endcan

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Category Name</th>
                    <th>Show Products</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>

                        <td>{{ $category->name }}</td>

                        <td>
                            <a href="{{ route('products.index', ['category_id' => $category->id]) }}"
                               class="btn show-products-btn">
                                Show Products
                            </a>
                        </td>

                        <td>
                            <div class="action-buttons">

                                @can('update', $category)
                                    <a href="{{ route('categories.edit', $category) }}"
                                       class="btn edit-btn">
                                        Edit
                                    </a>
                                @endcan

                                @can('delete', $category)
                                    <form action="{{ route('categories.destroy', $category) }}"
                                          method="POST"
                                          onsubmit="return confirm('Are you sure you want to delete this category?');">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn delete-btn">
                                            Delete
                                        </button>
                                    </form>
                                @endcan

                            </div>
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="4" class="text-center">
                            No categories found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="back-button">
        <a href="{{ route('products.index') }}" class="btn back-btn">
            Show list Products
        </a>

        <a href="{{ route('notifications.index') }}" class="btn">
            Show Notifications
        </a>
        
        @if (auth()->user()?->isAdmin())
        <a href="{{ route('suppliers.index') }}" class="btn back-btn">
            Show Suppliers
        </a>

        <a href="{{ route('stock-movements.index') }}" class="btn back-btn">
            Show Stock Movements
        </a>
        @endif
    </div>
@endsection
