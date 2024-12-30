@extends('layouts.admin.master', ['title' => 'Edit - Bookstore'])

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Edit Slider</h4>
                <form action="{{ route('admin.sliders.update', $slider->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="image">Slider Image</label>
                        <input type="file" name="image" id="image" class="form-control">
                        <img src="{{$slider->image }}" alt="Slider Image" width="100" class="mt-2">
                        @error('image')
                        <div class="invalid-feedback">
                            {{ $message ?: 'The image must be a valid image file (jpeg, png, bmp, gif, svg, or webp).' }}
                        </div>
                    @enderror
                    </div>
                    
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">Update Slider</button>
                        <a href="{{ route('admin.sliders.index') }}" class="btn btn-secondary">Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection