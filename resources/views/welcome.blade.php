@extends('layouts.indexl')

@section('content')
<div class="container">
    <div class="jumbotron mt-4">
        <h1 class="display-4">Selamat datang di {{ config('app.name', 'Laravel') }}</h1>
        <p class="lead">aplikasi digunakan untuk assessement guru dan siswa.</p>
        <hr class="my-4">
        <p>gunakan navigasi di bawah atau di bagian atas untuk registrasi dan login.</p>
        <a class="btn btn-warning btn-lg" href="{{ route('register') }}" role="button">Register</a>
        <a class="btn btn-success btn-lg" href="{{ route('login') }}" role="button">Login</a>
    </div>
</div>
@endsection
