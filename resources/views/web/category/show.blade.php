@extends('layouts.web.master', ['title' => $category->name . ' - Bookstore'])

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Books in Category: {{ $category->name }}</h2>
    <hr />

    @if($category->books->isEmpty())
    <div class="alert alert-warning text-center">
        No books available in this category.
    </div>
    @else
    <div class="row g-3 justify-content-center">
        @foreach($category->books as $book)
        <div class="col-6 col-sm-6 col-md-4">
            <div class="card h-100 shadow border-0">
                <img src="{{ $book->images->first() ? asset($book->images->first()->image) : 'https://via.placeholder.com/300x260?text=Book+Image' }}"
                    class="w-100 rounded img-fluid object-fit-cover h-100 rounded-3" alt="{{ $book->title }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $book->title }}</h5>
                    <p class="card-text text-muted">Rp {{ number_format($book->price, 2) }}</p>
                    <a href="" class="btn btn-primary w-100">View Details</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection