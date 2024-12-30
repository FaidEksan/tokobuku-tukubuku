@extends('layouts.admin.master', ['title' => 'Edit - Bookstore'])

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Edit Book: {{ $book->title }}</h4>

                <!-- Form for editing the book -->
                <form action="{{ route('admin.books.update', $book->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Select Category with Error Message -->
                    <div class="form-group">
                        <label for="category_id">Category</label>
                        <select name="category_id" id="category_id" class="form-control" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $book->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Book Title with Error Message -->
                    <div class="form-group mt-3">
                        <label for="title">Book Title</label>
                        <input type="text" name="title" id="title" class="form-control" value="{{ $book->title }}" required>
                        @error('title')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Price with Error Message -->
                    <div class="form-group mt-3">
                        <label for="price">Price</label>
                        <input type="number" name="price" id="price" class="form-control" value="{{ $book->price }}" required>
                        @error('price')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Book Description with Error Message -->
                    <div class="form-group mt-3">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" class="form-control" required>{{ $book->description }}</textarea>
                        @error('description')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">Update Book</button>
                        <a href="{{ route('admin.books.index') }}" class="btn btn-secondary">Back</a>
                    </div>
                </form>

                <!-- Section for managing book images -->
                <div class="mt-4">
                    <h5>Manage Book Images</h5>
                    <a href="" class="btn btn-sm btn-success">Manage Images</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection