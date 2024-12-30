@extends('layouts.admin.master', ['title' => 'Dashboard - Bookstore'])

@section('content')
    <h1>Admin Dashboard</h1>
    <p>Selamat datang, {{ $user->name }}! Ini adalah halaman dashboard untuk admin.</p>
@endsection