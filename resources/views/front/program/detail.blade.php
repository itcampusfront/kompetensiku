@extends('layout.main')

@section('title', $program->program_title . ' - Program | ')
@php
    $program_materi = json_decode($program->program_materi);
    $materi_desk = json_decode($program->materi_desk);
    $price = json_decode($program->price);
    $info_profesi = json_decode($program->info_profesi);

@endphp
{{-- @dd($program) --}}
@section('content')
    <div>
        <div class="container p-top">
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
                        <div class="col-lg-8 order-2 order-lg-1 ">
                            <span class=" text-white badge bg-theme-1 mb-3 p-2">{{ $program->kategori }}</span>
                            <h2 class="mb-3 text-white " id="program_name">{{ $program->program_title }}</h2>
                            {{-- <p>Oleh : {{ $program->nama_user }}<br> Terakhir diperbarui
                                {{ date('d/m/Y', strtotime($program->program_at)) }}</p> --}}
                            {{-- <a href="{{ route('auth.login') }}" class="btn btn-light">Ambil Pelatihan</a> --}}
                            <div class="card rounded-2 border-0 shadow-sm">
                                <div class="card-body">
                                    <div class="ql-snow">
                                        <div class="ql-editor">{!! html_entity_decode($program->konten) !!}</div>
                                    </div>
                                </div>
                            </div>
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
                    <div class="col-12 mb-3 mb-lg-0">
                        {{-- <div class="div-konten">
                            @include('front.program.part_program', [
                                'title' => 'Ringkasan',
                                'content' => html_entity_decode($program->konten),
                            ])
                        </div> --}}

                        <div class="div-manfaat">
                            @include('front.program.part_program', [
                                'title' => 'Manfaat Program',
                                'content' => html_entity_decode($program->program_manfaat),
                            ])
                        </div>
                        @if ($program_materi != null)

                            <div class="div-materi">
                                <div class="heading mt-3">
                                    <h5 class="font-weight-bold">Materi </h5>
                                </div>
                                <div class="card rounded-2 border-0 shadow-sm">
                                    <div class="container p-3">
                                        <div class="row">
                                            @foreach ($program_materi as $index => $judul)
                                                <div class="col-12 col-md-6 g-2 d-flex">
                                                    <div class="card mb-2 w-100 h-100 d-flex flex-column">
                                                        <div class="card-header text-white text-center bg-theme-2">
                                                            <b>{{ $judul }}</b>
                                                        </div>
                                                        <div style="font-size:20px"
                                                            class="card-body p-4 d-flex align-items-center justify-content-center text-center">
                                                            {{ $materi_desk[$index] }}
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if ($price != null)
                            <div class="div-harga">
                                <div class="heading mt-3">
                                    <h5 class="font-weight-bold">Harga Pelatihan </h5>
                                </div>
                                <div class="card shadow-sm">
                                    <div class="card-bod text-center p-5">
                                        <span style="font-size: 24px">Harga Normal : <s
                                                style="font-size:24px;color: green">{{ 'Rp ' . number_format($price[0], 0, ',', '.') }}</s></span>
                                        <h1 class="bg-danger text-white rounded p-3 mt-2"> Harga Diskon :
                                            <u>{{ 'Rp ' . number_format($price[1], 0, ',', '.') }}</u>
                                        </h1>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if ($info_profesi != null)

                            <div class="div-profesi">
                                <div class="heading mt-3">
                                    <h5 class="font-weight-bold">Profesi Terkait</h5>
                                </div>
                                <div class="card rounded-2 border-0 shadow-sm">
                                    <div class="container">
                                        <div class="row g-2 m-3">
                                            @foreach ($info_profesi as $profesi)
                                                <div class="col-12 col-sm-6 col-md-4 col-lg-2">
                                                    <div class="card border-0" style="width: 100%">
                                                        <div class="d-flex justify-content-center align-items-center"
                                                            style="height: 100px;">
                                                            <img class="img-fluid rounded"
                                                                style="max-height: 100px; max-width: 100px;"
                                                                src="{{ file_exists(public_path('assets/images/program/icon-profesi/' . $profesi->icon_profesi)) ? asset('assets/images/program/icon-profesi/' . $profesi->icon_profesi) : asset('assets/images/default/program.png') }}"
                                                                alt="{{ $profesi->name_profesi }}">
                                                        </div>
                                                        <div class="card-body">
                                                            <p class="card-text text-center">{{ $profesi->name_profesi }}
                                                            </p>
                                                        </div>
                                                    </div>

                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="row mt-3 g-1">
                    <div class="col-12 col-lg-6 order-1">
                        {{-- <h2 style="color:red">Segera Daftarkan Dirimu</h2> --}}
                        <div class="form-container shadow">
                            <h5 class="form-title mb-4">Daftar Kelas atau Pelatihan Melalui WhatsApp, Isi Form Dibawah ⬇️</h5>
                            <form id="whatsappForm">
                                <div class="mb-3">
                                    <label for="nama" class="form-label">*Nama</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fa fa-person"></i></span>
                                        <input type="text" class="form-control" id="nama" placeholder="Nama Anda"
                                            required>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">*Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                        <input type="email" class="form-control" id="email" placeholder="Email Anda"
                                            required>
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
                                <div class="mb-3">
                                    <label for="hp" class="form-label">*Nama Program</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                        <input type="text" class="form-control" id="name_program"
                                            placeholder="Program Batch 30 atau Pelatihan Reguler" required>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-yellow w-100">Daftar Via WhatssApp</button>
                            </form>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 order-0">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="widget_title">Event Pelatihan Berjalan</h5>
                            </div>
                            <div class="card-body">
                                @if ($pelatihan != null)
                                @foreach ($pelatihan as $index => $data)
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <!-- Countdown -->
                                            <div class="countdown-box bg-danger text-white p-3 rounded mb-3 text-center shadow-sm">
                                                <div id="countdown-{{ $index }}"
                                                     class="countdown-time fw-bold"
                                                     data-date="{{ \Carbon\Carbon::parse($data->tanggal_pelatihan_to)->toIso8601String() }}">
                                                    Memuat...
                                                </div>
                                            </div>
                    
                                            <div class="row">
                                                <div class="col-12 text-center">
                                                    <img class="img-fluid rounded"
                                                         style="height: auto;max-width:100%"
                                                         src="{{ file_exists(public_path('assets/images/pelatihan/' . $data->gambar_pelatihan)) ? asset('assets/images/pelatihan/' . $data->gambar_pelatihan) : asset('assets/images/default/program.png') }}"
                                                         alt="Gambar Pelatihan {{ $data->nama_pelatihan }}">
                                                </div>
                                                <div class="col-12">
                                                    <p class="fs-4 fw-bold"> {{ strtoupper($data->nama_pelatihan) }} </p>
                                                    <p class="text-muted"><i class="fa fa-map-marker" aria-hidden="true"></i>
                                                        {{ strtoupper($data->tempat_pelatihan) }}</p>
                                                    <p class="text-muted"><i class="fa fa-clock" aria-hidden="true"></i>
                                                        <span style="color:red">{{ $data->total_jam_pelatihan }} Jam</span> PERTEMUAN
                                                    </p>
                                                    <div class="mx-auto">
                                                        <!-- Tombol Modal -->
                                                        <button class="btn bg-theme-2 text-white"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#modalPelatihan{{ $index }}">
                                                            Informasi Pelatihan
                                                        </button>
                    
                                                        @if (Auth::guest())
                                                            <a class="btn bg-theme-2 text-white" href="{{ route('auth.login') }}">Daftar / Login Untuk Mendaftar Pelatihan</a>
                                                        @else
                                                            <a target="__blank" class="btn bg-theme-2 text-white" href="/member/pelatihan/detail/{{ $data->id_pelatihan }}">
                                                                Daftar Melalui Sistem
                                                            </a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                    
                                <!-- Modal -->
                                <div class="modal fade" id="modalPelatihan{{ $index }}" tabindex="-1" aria-labelledby="modalLabel{{ $index }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalLabel{{ $index }}">Informasi Lengkap Pelatihan</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                            </div>
                                            <div class="modal-body">
                                                <h4 class="fw-bold">{{ $data->nama_pelatihan }}</h4>
                                                <p><strong>Tempat:</strong> {{ $data->tempat_pelatihan }}</p>
                                                <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($data->tanggal_pelatihan_from)->translatedFormat('d F Y') }} -
                                                    {{ \Carbon\Carbon::parse($data->tanggal_pelatihan_to)->translatedFormat('d F Y') }}</p>
                                                <p><strong>Total Jam:</strong> {{ $data->total_jam_pelatihan }} Jam</p>
                                                <p><strong>Deskripsi:</strong></p>
                                                <div>{!! html_entity_decode($data->deskripsi_pelatihan) !!}</div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                                @else
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <div class="mb-3">

                                                <div class="d-flex">
                                                    <img class="rounded mb-2"
                                                        src="{{ asset('assets/images/pelatihan/' . $data->gambar_pelatihan) }}"
                                                        alt="Gambar Pelatihan {{ $data->nama_pelatihan }}">
                                                    <div class="text">
                                                        <p class="fs-4 fw-bold"> {{ strtoupper($data->nama_pelatihan) }}
                                                        </p>
                                                        <p class="text-muted"><i class="fa fa-map-marker"
                                                                aria-hidden="true"></i>
                                                            {{ strtoupper($data->tempat_pelatihan) }}</p>
                                                        <p class="text-muted"><i class="fa fa-clock"
                                                                aria-hidden="true"></i> <span
                                                                style="color:red">{{ $data->total_jam_pelatihan }} Jam
                                                            </span>PERTEMUAN</p>
                                                        <p>
                                                            @if (Auth::guest())
                                                                <a class="btn btn-theme-1"
                                                                    href="{{ route('auth.register') }}">Daftar / Login</a>
                                                            @else
                                                                <a target="__blank" class="btn btn-theme-1"
                                                                    href="/member/pelatihan/detail/{{ $data->id_pelatihan }}">Daftar
                                                                    Melalui Sistem</a>
                                                            @endif
                                                        </p>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
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
            height: 100%;
            /* margin: 50px auto; */
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

        .countdown-box {
            background: white;
            border-radius: 1rem;
            padding: 2rem 3rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .countdown-title {
            font-size: 1.8rem;
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .countdown-time {
            font-size: 1.5rem;
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
            const name_program = document.getElementById("name_program").value;
            const program_name = document.getElementById("program_name").innerHTML;

            const pesan = `Halo Admin Kompetensiku, Saya, %0A` +
                `Nama: ${nama}%0A ` +
                `Email: ${email}%0A ` +
                `Nomor HP: ${hp}%0A%0A ` +
                `Nama Program: ${name_program}%0A%0A ` +
                `ingin Mendaftarkan diri untuk mengikuti program ${program_name}`;

            const noWa = "62816343741";
            const url = `https://wa.me/${noWa}?text=${pesan}`;
            window.open(url, "_blank");
        });


        // Loop semua elemen dengan class countdown-time
        document.querySelectorAll('.countdown-time').forEach(function(el) {
            const countdownElement = el;
            const targetDate = new Date(countdownElement.getAttribute('data-date')).getTime();

            function updateCountdown() {
                const now = new Date().getTime();
                const distance = targetDate - now;

                if (distance < 0) {
                    countdownElement.innerHTML = "Waktu sudah lewat!";
                    clearInterval(timer);
                    return;
                }

                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                countdownElement.innerHTML =
                    `${days} hari, ${hours} jam, ${minutes} menit, ${seconds} detik`;
            }

            // Jalankan awal dan update per detik
            updateCountdown();
            const timer = setInterval(updateCountdown, 1000);
        });
    </script>

@endsection
