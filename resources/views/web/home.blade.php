@extends('layouts.web.master', ['title' => 'Home - Bookstore'])

@section('content')

<div id="carouselExampleCaptions" class="carousel slide py-3" data-bs-ride="carousel">
    <div class="carousel-inner ">
        @foreach ($sliders as $key => $slider)
        <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
            <img src="{{  $slider->image }}" class="d-block w-100 rounded-3" alt="Slider Image">
        </div>
        @endforeach
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

<!-- Categories Section  -->
<div class="py-3">
    <div class="row text-center mb-3">
        <div class="col-md-12">
            <h2 class="section-title">Categories</h2>
        </div>
    </div>
    <div class="row g-3 justify-content-center">
        @foreach($categories as $category)
        <div class="col-6 col-sm-6 col-md-3">
            <div class="category-card shadow rounded-3 p-3 bg-white rounded h-100">
                <a href="{{ route('categories.show', $category->slug) }}">
                    <div class="mb-2">
                        @if($category->image)
                        <img src="{{ $category->image }}" class="w-100 h-100 rounded" alt="{{ $category->name }}">
                        @else
                        <img src="https://via.placeholder.com/200x150?text={{ $category->name }}" class="w-100 rounded"
                            alt="{{ $category->name }}">
                        @endif
                    </div>
                    <hr />
                    <div class="text-center">
                        <h6 class="category-title">{{ $category->name }}</h6>
                    </div>
                </a>
            </div>
        </div>

        @endforeach
    </div>
</div>


<!-- Books Section -->
<div class="py-3 ">
    <div class="row text-center mb-3">
        <div class="col-md-12">
            <h2 class="section-title"> Books</h2>
            <p class="text-muted">Explore our collection of top books</p>
        </div>
    </div>

    <div class="row g-3 justify-content-center">
        @foreach($books as $book)
        <div class="col-6 col-sm-6 col-md-3">
            <a href="{{ route('books.show', $book->slug) }}" class="text-decoration-none text-dark">
                <div class="product-card shadow p-1  bg-white rounded h-100 d-flex flex-column">
                    <div className="card shadow text-center">
                        @if ($book->images->isNotEmpty() && $book->images->first()->image)
                        <img src="{{ $book->images->first()->image }}"
                            class="w-100 rounded img-fluid object-fit-cover h-100 rounded-3" alt="{{ $book->title }}">
                        @endif
                    </div>
                    <div class="product-card-body text-center flex-grow-1 d-flex flex-column justify-content-between">
                        <div>
                            <p class="product-brand mb-1 text-muted">{{ $book->author }}</p>
                            <h5 class="product-title mb-2">{{ $book->title }}</h5>
                            <div class="product-price">
                                <p class="selling-priceh4 fw-bold">Rp {{ number_format($book->price) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>


@endsection