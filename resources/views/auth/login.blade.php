@extends('layouts.web.master', ['title' => 'Login - Bookstore'])

@section('content')
<div class="row w-100 mx-0">
  <div class="col-lg-8 mx-auto">
    <div class="auth-form-light text-left py-5 px-4 px-sm-5">
      <h6 class="font-weight-light">Sign in to continue.</h6>

      <form method="POST" action="{{ route('login') }}" class="pt-3">
        @csrf
        <div class="form-group">
          <input type="email" class="form-control form-control-lg" id="email" name="email" placeholder="Email" value="{{ old('email') }}">
          @error('email')
          <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>

        <div class="form-group">
          <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Password">
          @error('password')
          <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>

        @if (session('status'))
        <div class="alert alert-danger">
          {{ session('status') }}
        </div>
        @endif

        <div class="mt-3 d-grid gap-2">
          <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">SIGN IN</button>
        </div>

        <div class="text-center mt-4 font-weight-light">
          Don't have an account? <a href="{{ route('register') }}" class="text-primary">Create</a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection