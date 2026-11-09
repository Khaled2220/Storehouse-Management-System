@extends('layouts.app')

@section('title', 'Edit Category')

@section('content')

    @can('update', $category)

        <h2>Edit Category</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form class="category-form"
              method="POST"
              action="{{ route('categories.update', $category) }}">

            @csrf
            @method('PUT')

            <div class="form-group">

                <label for="name">
                    Category Name:
                </label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    class="form-control"
                    value="{{ old('name', $category->name) }}"
                    required
                    autofocus
                >

                @error('name')
                    <small class="text-danger">
                        {{ $message }}
                    </small>
                @enderror

            </div>

            <div class="action-buttons">

                <button type="submit" class="btn update-btn">
                    Update Category
                </button>

            </div>

        </form>

    @else

        <div class="alert alert-danger">
            <h4>Unauthorized access!</h4>

            <p>
                You do not have permission to edit this category.
            </p>
        </div>

    @endcan

    <div class="back-button">

        <a href="{{ route('categories.index') }}"
           class="btn back-btn">
            Back to Categories
        </a>

    </div>

@endsection
