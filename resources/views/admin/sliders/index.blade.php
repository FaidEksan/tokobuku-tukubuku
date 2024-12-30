@extends('layouts.admin.master', ['title' => 'Sliders - Bookstore'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="card-title">Sliders</h4>
            <a href="{{ route('admin.sliders.create') }}" class="btn btn-primary">Add New Slider</a>
        </div>

        <!-- Sliders Table -->
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sliders as $slider)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <img src="{{ $slider->image }}" alt="Slider Image" width="100">
                                </td>
                                <td>
                                    <a href="{{ route('admin.sliders.edit', $slider->id) }}" class="btn btn-sm btn-warning">Edit</a>

                                    <form action="{{ route('admin.sliders.destroy', $slider->id) }}" method="POST" class="delete-form d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger delete-btn">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">No sliders available.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-3">
                    {{ $sliders->withQueryString()->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection