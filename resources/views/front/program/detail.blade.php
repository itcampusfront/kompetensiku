@extends('template.main')

@section('title', $program->program_title . ' - Program | ')
@php
    $program_materi = json_decode($program->program_materi);
    $materi_desk = json_decode($program->materi_desk);
    $price = json_decode($program->price);
@endphp
{{-- @dd($program) --}}
@section('content')
    <div>
        <div class="container mt-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-white p-3 shadow-sm rounded-1">
                    <li class="breadcrumb-item"><a href="{{ route('site.home') }}"><i class="fas fa-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('site.program.index') }}">Program</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <span>{{ $program->program_title }}</span>
                    </li>
                </ol>
            </nav>
        </div>
        <section>
            <div class="bg-theme-2">
                <div class="container pt-0 pt-md-4 pb-4 mb-4 mb-lg-0">
                    <div class="row">
                        <div class="col-lg-8 order-2 order-lg-1 text-white">
                            <span class="badge bg-theme-1 mb-3 p-2">{{ $program->kategori }}</span>
                            <h2 class="mb-3" id="program_name">{{ $program->program_title }}</h2>
                            {{-- <p>Oleh : {{ $program->nama_user }}<br> Terakhir diperbarui
                                {{ date('d/m/Y', strtotime($program->program_at)) }}</p> --}}
                            <a href="{{ route('auth.login') }}" class="btn btn-light">Ambil Pelatihan</a>
                        </div>
                        <div class="col-lg-4 order-1 order-lg-2 px-0 px-md-3">
                            <img class="img-fluid rounded mb-3 mb-lg-0"
                                src="{{ image('assets/images/program/' . $program->program_gambar, 'program') }}">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="my-3">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 mb-3 mb-lg-0">
                        @include('front.program.part_program', [
                            'title' => 'Ringkasan',
                            'content' => html_entity_decode($program->konten),
                        ])
                        @include('front.program.part_program', [
                            'title' => 'Manfaat Program',
                            'content' => html_entity_decode($program->program_manfaat),
                        ])

                        <div class="heading mt-3">
                            <h5 class="font-weight-bold">Materi </h5>
                        </div>
                        <div class="card rounded-2 border-0 shadow-sm">
                            <div class="container p-3">
                                <div class="row">
                                    @foreach ($program_materi as $index => $judul)
                                        <div class="col-12 col-md-6 g-2 d-flex">
                                            <div class="card mb-2 w-100 h-100 d-flex flex-column">
                                                <div class="card-header text-center bg-white">
                                                    <b>{{ $judul }}</b>
                                                </div>
                                                <div
                                                    class="card-body p-4 d-flex align-items-center justify-content-center text-center">
                                                    {{ $materi_desk[$index] }}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="heading mt-3">
                            <h5 class="font-weight-bold">Harga Pelatihan </h5>
                        </div>
                        <div class="card bg-light shadow-sm m-3">
                          <div class="card-bod text-center p-5">
                              <s
                                  style="font-size:24px;color: green">{{ 'Rp ' . number_format($price[0], 0, ',', '.') }}</s>
                              <h1 style="color:red"><u>{{ 'Rp ' . number_format($price[1], 0, ',', '.') }}</u></h1>
                          </div>
                      </div>
                        <div class="container">
                            <div class="form-container shadow">
                                <h5 class="form-title mb-4">Daftar Kelas, Isi Form Dibawah ⬇️</h5>
                                <form id="whatsappForm">
                                    <div class="mb-3">
                                        <label for="nama" class="form-label">*Nama</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                                            <input type="text" class="form-control" id="nama"
                                                placeholder="Nama Anda" required>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="email" class="form-label">*Email</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                            <input type="email" class="form-control" id="email"
                                                placeholder="Email Anda" required>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="hp" class="form-label">*Nomor Handphone</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                            <input type="text" class="form-control" id="hp" placeholder="Nomor HP"
                                                required>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-yellow w-100">Daftar Via WhatssApp</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <h5 class="widget_title">Pelatihan Lainnya</h5>
                        <div class="card mb-3">
                            <div class="card-body">
                                @foreach ($program_lainnya as $data)
                                    <a class="text-body"
                                        href="{{ route('site.program.detail', ['permalink' => $data->program_permalink]) }}">
                                        <div class="d-flex mb-3">
                                            <img class="rounded flex-shrink-0 me-3" width="70"
                                                src="{{ image('assets/images/program/' . $data->program_gambar, 'program') }}"
                                                alt="post">
                                            <span>{{ $data->program_title }}</span>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('css-extra')
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <style>
        .form-container {
            max-width: 100%;
            margin: 50px auto;
            padding: 30px;
            border: 1px solid #ddd;
            border-radius: 10px;
        }

        .form-title {
            text-align: center;
            font-weight: bold;
            color: #007bff;
        }

        .btn-yellow {
            background-color: green;
            color: #fff;
            font-weight: bold;
        }
    </style>
@endsection

@section('js-extra')
    <script>
        document.getElementById("hp").addEventListener("input", function(e) {
            this.value = this.value.replace(/\D/g, ""); // Hapus semua non-digit
        });
        document.getElementById("whatsappForm").addEventListener("submit", function(e) {
            e.preventDefault();
            const nama = document.getElementById("nama").value;
            const email = document.getElementById("email").value;
            const hp = document.getElementById("hp").value;
            const program_name = document.getElementById("program_name").innerHTML;

            const pesan = `Halo Admin Kompetensiku, Saya, %0A` +
                `Nama: ${nama}%0A ` +
                `Email: ${email}%0A ` +
                `Nomor HP: ${hp}%0A%0A ` +
                `ingin Mendaftarkan diri untuk mengikuti program ${program_name}`;

            const noWa = "62816343741";
            const url = `https://wa.me/${noWa}?text=${pesan}`;
            window.open(url, "_blank");
        });
    </script>

@endsection
