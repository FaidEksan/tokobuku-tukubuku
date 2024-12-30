@extends('layouts.admin.master', ['title' => 'Edit - Bookstore'])

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Edit Category</h4>

                <!-- Form for editing a category -->
                <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT') <!-- Method PUT for update -->

                    <!-- Field Nama Kategori -->
                    <div class="form-group">
                        <label for="name">Category Name</label>
                        <input
                            type="text"
                            class="form-control @error('name') is-invalid @enderror"
                            id="name"
                            name="name"
                            placeholder="Category Name"
                            value="{{ old('name', $category->name) }}"
                            required
                        >
                        <!-- Display error message for name -->
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message ?: 'The category name is required and must be at least 3 characters.' }}
                            </div>
                        @enderror
                    </div>

                    <!-- Field Gambar Kategori -->
                    <div class="form-group">
                        <label for="image">Category Image</label>
                        <!-- Display current image if exists -->
                        @if($category->image)
                            <div class="mb-2">
                                <img src="{{ $category->image }}" alt="Category Image" width="100">
                            </div>
                        @endif
                        <input
                            type="file"
                            class="form-control @error('image') is-invalid @enderror"
                            id="image"
                            name="image"
                        >
                        <small class="text-muted">Leave blank if you don't want to change the image</small>
                        <!-- Display error message for image -->
                        @error('image')
                            <div class="invalid-feedback">
                                {{ $message ?: 'The image must be a valid image file (jpeg, png, bmp, gif, svg, or webp).' }}
                            </div>
                        @enderror
                    </div>

                    <!-- Submit and Back Button -->
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">Update Category</button>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection