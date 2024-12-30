@extends('layouts.web.master', ['title' => $book->title . ' - Bookstore'])

@section('content')

<div class="py-3">
    <div class="row">
        <div class="col-md-4 mt-3">
            <!-- Gambar Utama Buku yang dapat diklik untuk membuka modal -->
            <img src="{{ $book->images->first() ? $book->images->first()->image : 'https://via.placeholder.com/300x260?text=Book+Image' }}"
                class="w-100 rounded img-fluid object-fit-cover mb-3" style="max-height: 400px; cursor: pointer;"
                alt="{{ $book->title }}" data-bs-toggle="modal" data-bs-target="#imageModal">

            <!-- Modal untuk Carousel Gambar -->
            <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-sm modal-dialog-centered ">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="imageModalLabel">{{ $book->title }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Carousel di dalam Modal -->
                            <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    @foreach ($book->images as $key => $image)
                                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                        <img src="{{ $image->image }}" class="d-block w-100 rounded-3"
                                            alt="Additional Image">
                                    </div>
                                    @endforeach
                                </div>
                                <button class="carousel-control-prev" type="button"
                                    data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button"
                                    data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of Modal -->
        </div>

        <!-- Bagian Detail Buku -->
        <div class="col-md-8 mt-3">
            <div class="product-view">
                <h3 class="product-name">{{ $book->title }}</h3>
                <p class="product-path text-muted mt-2">
                    <a href="">{{ $book->category->name }}</a> / {{ $book->title }}
                </p>
                <div class="mt-3">
                    <p class="selling-priceh4 fw-bold">Rp {{ number_format($book->price) }}</p>
                </div>
                <div class="mt-4">
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="book_id" value="{{ $book->id }}">
                        <input type="number" name="qty" value="1" min="1" class="form-control d-inline-block w-auto me-2">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="fa fa-shopping-cart"></i> Add To Cart
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <hr />
    <!-- Bagian Deskripsi Buku -->
    <div class="mt-4">
        <h4>Description</h4>
        <p class="text-muted display-5">
            {{ $book->description }}
        </p>
    </div>
</div>

@endsection