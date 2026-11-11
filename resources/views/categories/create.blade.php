@extends('layouts.app')

@section('title', 'Add New Category')

@section('content')

    @can('create', \App\Models\Category::class)

        <h2>Add New Category</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form class="category-form" method="POST" action="{{ route('categories.store') }}">
            @csrf

            <div class="form-group">
                <label for="name"> Category Name: </label>

                <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required autofocus >

                @error('name')
                    <small class="text-danger"> {{ $message }} </small>
                @enderror
            </div>

            <div class="action-buttons">
                <button type="submit" class="btn save-btn">
                    Save Category
                </button>
            </div>
        </form>

    @else
        <div class="alert alert-danger">
            <h4>Unauthorized access!</h4>

            <p>
                You do not have permission to add categories.
            </p>
        </div>
    @endcan

    <div class="back-button">
        <a href="{{ route('categories.index') }}" class="btn back-btn">
            Back to Categories
        </a>
    </div>
@endsection
