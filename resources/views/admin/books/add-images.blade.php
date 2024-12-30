@extends('layouts.admin.master', ['title' => 'Add Image Book - Bookstore'])
@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Add Images for: {{ $book->title }}</h4>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.books.store-images', $book->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="images">Book Images</label>
                        <input type="file" name="images[]" id="images" class="form-control" multiple required>
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">Add Images</button>
                        <a href="{{ route('admin.books.index') }}" class="btn btn-secondary">Back</a>
                    </div>
                </form>

                @if($book->images->count() > 0)
                    <div class="mt-3">
                        <div class="row">
                            @foreach($book->images as $image)
                            <div class="col-md-3 text-center mb-3">
                                <img src="{{ $image->image }}" alt="Book Image" class="img-fluid" >
                                <form action="{{ route('admin.books.delete-image', $image->id) }}" method="POST" class="delete-form d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger delete-btn mt-3">Delete</button>
                                </form>
                            </div>
                        @endforeach

                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection