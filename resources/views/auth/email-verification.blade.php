@extends('template.main')

@section('title', 'Cek Email | ')

@section('content')

    <div class="main-wrapper my-3">
        <div class="auth-wrapper d-flex no-block justify-content-center align-items-center">
            <div class="container">
                @if($status == 1)
                    <div class="alert alert-success text-center p-5">Pengguna dengan email <strong>{{ $_GET['email'] }}</strong> sudah terverifikasi. Silahkan <a href="/login">Login disini</a>.</div>
                @elseif($status == 0)
                    <div class="alert alert-danger text-center p-5">Tidak ada pengguna yang terdaftar dengan email <strong>{{ $_GET['email'] }}</strong>. Pastikan Anda benar-benar mendaftar menggunakan email ini atau tidak.</div>
                @endif
            </div>
        </div>
    </div>

@endsection