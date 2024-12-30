@extends('layouts.admin.master', ['title' => 'Dashboard - Bookstore'])

@section('content')
    <h1>Dashboard Customer</h1>
    <p>Selamat datang, {{ Auth::user()->name }}!</p>
    <p>Ini adalah halaman dashboard untuk customer.</p>
@endsection