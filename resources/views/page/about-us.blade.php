@extends('template.main')

@section('title', 'Tentang Kami | ')

@section('content')
<div class="bg-theme-1 text-center" style="height: 200px">
    <h3 class="text-white pt-5">Selamat Datang</h3>
</div>
<div class="container" style="top: -5em; position: relative;">
    <div class="card">
        <div class="card-body">
            <div class="d-block d-lg-flex">
                <div class="text-center text-lg-start mb-3 mb-lg-0">
                    <img width="130" class="me-3 flex-shrink-0" src="{{ asset('assets/images/icon/'.setting('site.icon')) }}">
                </div>
                <div class="content">
                    <p>Selamat datang di Kompetensiku. Kami adalah Konsultan Pengembangan Kompetensi Sumber Daya Manusia dan Pusat Pendidikan dan pelatihan untuk para praktisi pengembangan sumber daya manusia (HRD) dengan Sertifikat BNSP (Badan Nasional Sertifikasi Profesi) untuk skema staf SDM, supervisor SDM, kepala bagian SDM, manajer SDM, dan direktur SDM.</p>
                    <a href="https://wa.me/{{ setting('site.whatsapp') }}" class="btn btn-theme-1" target="_blank"><i class="fab fa-whatsapp"></i> Hubungi Kami</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container mb-5">
    <div class="heading text-center mb-5">
        <h3>Program Pelatihan dan Sertifikasi Praktisi Sumber Daya Manusia</h3>
        <div class="rounded-2 w-25 mx-auto" style="border: 3px solid var(--color-1)"></div>
    </div>
    <div class="row">
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card h-100">
                <div class="card-header bg-transparent">
                    <h5 class="m-0">Level Staf</h5>
                </div>
                <p>
                    <ol class="level-list">
                        <li>Staf Kompensasi dan Benefit</li>
                        <li>Staf Penggajian</li>
                        <li>Staf Renumerasi</li>
                        <li>Staf Administrasi Sumber Daya Manusia (SDM)</li>
                        <li>Staf Sumber Daya Manusia (SDM)</li>
                        <li>Staf Perencanaan Sumber Daya Manusia (SDM)</li>
                        <li>Staf Rekrutmen dan Seleksi (SRS)</li>
                        <li>Staf Manajemen Talenta (SMT)</li>
                    </ol>
                </p>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card h-100">
                <div class="card-header bg-transparent">
                    <h5 class="m-0">Level Supervisor</h5>
                </div>
                <p>
                    <ol class="level-list">
                        <li>Supervisor Pengadaan, Penyeleksian, dan Penempatan Sumber Daya Manusia (SPPPSDM)</li>
                        <li>Supervisor Pelatihan dan Pengembangan Sumber Daya Manusia (SPPSDM)</li>
                        <li>Supervisor Hubungan Industrial (SHI)</li>
                        <li>Supervisor Manajemen Kinerja dan Karir (SMKK)</li>
                        <li>Supervisor Manajemen Talenta (SMT)</li>
                    </ol>
                </p>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card h-100">
                <div class="card-header bg-transparent">
                    <h5 class="m-0">Level Manajer</h5>
                </div>
                <p>
                    <ol class="level-list">
                        <li>Manajer Sumber Daya Manusia (MSDM)</li>
                        <li>Manajer Human Capital (MHC)</li>
                        <li>Manajer Pengembangan Sumber Daya Manusia (PSDM)</li>
                        <li>Manajer Administrasi dan Personalia (MAP)</li>
                    </ol>
                </p>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="heading text-center mb-5">
        <h3>Mengapa Kami?</h3>
        <div class="rounded-2 w-25 mx-auto" style="border: 3px solid var(--color-1)"></div>
    </div>
    <div class="row justify-content-center">

        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card h-100">
                <div class="card-header bg-transparent">
                    <div class="icon bg-theme-1 text-white p-3 rounded-1 w-fit mx-auto">
                        <i class="fs-1 fas fa-gem"></i>
                    </div>
                    <h3 class="text-center">Materi Berkualitas</h3>
                </div>
                <div class="card-body">
                    <div class="service-text">
                        <p>Kami bekerjasama dengan banyak Lembaga dan komunitas terbaik di Indonesia, tentunya materi yang akan anda terima akan sangat berkualitas, teori terbaik teknik terhebat akan anda pelajari, dan yang sangat penting setiap hari selalu ada materi pembelajaran baru (khusus E-Learning).</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card h-100">
                <div class="card-header bg-transparent">
                    <div class="icon bg-theme-1 text-white p-3 rounded-1 w-fit mx-auto">
                        <i class="fs-1 fas fa-book"></i>
                    </div>
                    <h3 class="text-center">Berbasis Kompetensi</h3>
                </div>
                <div class="card-body">
                    <div class="service-text">
                        <p>Program Pelatihan Berbasis Kompetensi dengan Standardisasi Nasional yang mengacu pada SKKNI (Standar Kompetensi Kerja Nasional Indonesia).</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card h-100">
                <div class="card-header bg-transparent">
                    <div class="icon bg-theme-1 text-white p-3 rounded-1 w-fit mx-auto">
                        <i class="fs-1 fas fa-graduation-cap"></i>
                    </div>
                    <h3 class="text-center">Bersertifikasi BNSP</h3>
                </div>
                <div class="card-body">
                    <div class="service-text">
                        <p>Dapatkan Pengakuan Kompeten dengan Sertifikat Nasional dari Badan Nasional Sertifikasi Profesi (BNSP) atas Profesi Anda untuk meningkatkan Kompetensi serta daya saing Anda..</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card h-100">
                <div class="card-header bg-transparent">
                    <div class="icon bg-theme-1 text-white p-3 rounded-1 w-fit mx-auto">
                        <i class="fs-1 fas fa-paper-plane"></i>
                    </div>
                    <h3 class="text-center">Distance Learning</h3>
                </div>
                <div class="card-body">
                    <div class="service-text">
                        <p>Program Pelatihan Berbasis Kompetensi yang dilakukan secara Online / Daring / Jarak Jauh (Distance Learning) dengan menggunakan Media Aplikasi Zoom Meeting dan WhatsApp sebagai Forum Diskusi lebih lanjut.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card h-100">
                <div class="card-header bg-transparent">
                    <div class="icon bg-theme-1 text-white p-3 rounded-1 w-fit mx-auto">
                        <i class="fs-1 fas fa-desktop"></i>
                    </div>
                    <h3 class="text-center">E-Learning Program</h3>
                </div>
                <div class="card-body">
                    <div class="service-text">
                        <p>Program Pelatihan Secara Mandiri dimana peserta mendapat akses Materi dan Modul Pelatihan dalam bentuk E-Book Digital, Video Tutorial dan Contoh Template Tugas yang wajib dikerjakan Peserta sesuai Skema yang dipilih.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card h-100">
                <div class="card-header bg-transparent">
                    <div class="icon bg-theme-1 text-white p-3 rounded-1 w-fit mx-auto">
                        <i class="fs-1 fas fa-handshake"></i>
                    </div>
                    <h3 class="text-center">Pelatihan Tatap Muka</h3>
                </div>
                <div class="card-body">
                    <div class="service-text">
                        <p>Program Pelatihan Berbasis Kompetensi yang dilakukan secara tatap muka langsung (dalam ruang kelas) dengan menggunakan Media, Bahan, dan Peralatan yang sesuai dengan Persyaratan dan Standar yang telah ditetapkan.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card h-100">
                <div class="card-header bg-transparent">
                    <div class="icon bg-theme-1 text-white p-3 rounded-1 w-fit mx-auto">
                        <i class="fs-1 fas fa-exchange-alt"></i>
                    </div>
                    <h3 class="text-center">Paket Uji Kompetensi</h3>
                </div>
                <div class="card-body">
                    <div class="service-text">
                        <p>Kami selaku TUK (Tempat Uji Kompetensi) terlisensi dari LSP (Lembaga Sertifikasi Profesi) memiliki 2 pilihan Paket Uji Kompetensi, yaitu Uji Kompetensi secara Daring / Online dan Uji Kompetensi secara Tatap Muka dalam ruang kelas.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card h-100">
                <div class="card-header bg-transparent">
                    <div class="icon bg-theme-1 text-white p-3 rounded-1 w-fit mx-auto">
                        <i class="fs-1 fas fa-heart"></i>
                    </div>
                    <h3 class="text-center">Harga Terjangkau</h3>
                </div>
                <div class="card-body">
                    <div class="service-text">
                        <p>Ilmu sehebat apapun tidak akan bermanfaat jika tidak bisa dipelajari oleh seseorang, oleh karena itu kami ingin membantu beragam kalangan masyarakat dengan memberikan pilihan paket pelatihan dengan harga yang sangat terjangkau bahkan ada yang GRATIS! Ini sebagai pembuktian kami bahwa setiap orang berhak untuk mendapatkan kesempatan untuk mengembangkan kemampuan mereka.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection