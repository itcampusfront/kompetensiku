<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePendaftarsTable extends Migration
{
    public function up()
    {
        Schema::create('pendaftars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('skema_jadwal_id')->constrained('skema_jadwals')->onDelete('cascade');
            $table->string('sumber_anggaran')->nullable();
            $table->string('pemberi_anggaran')->nullable();
            
            // Biodata Wajib
            $table->string('nik');
            $table->string('nama_lengkap');
            $table->string('jenis_kelamin');
            $table->string('tempat_lahir');
            $table->date('tgl_lahir');
            
            // Domisili, Kontak, Pendidikan & Pekerjaan (Opsional)
            $table->text('alamat_domisili')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('kota')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('no_telp')->nullable();
            $table->string('email')->nullable();
            $table->string('pendidikan_terakhir')->nullable();
            $table->string('nama_sekolah')->nullable();
            $table->string('jurusan')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->string('nama_perusahaan')->nullable();
            $table->string('jabatan')->nullable();
            $table->text('alamat_perusahaan')->nullable();
            $table->string('kodepos')->nullable();
            $table->string('no_telp_perusahaan')->nullable();
            $table->string('email_perusahaan')->nullable();
            
            // File Upload (1 - 8)
            $table->string('file_ijazah')->nullable(); // 01
            $table->string('file_sertifikat_pelatihan')->nullable(); // 02
            $table->string('file_surat_pengalaman')->nullable(); // 03
            $table->string('file_pas_foto'); // 04 - Wajib
            $table->string('file_identitas'); // 05 - Wajib (KTP/Kartu Pelajar)
            $table->string('file_portofolio_upgrading')->nullable(); // 06
            $table->string('file_portofolio_laporan')->nullable(); // 07
            $table->string('file_portofolio_pengalaman')->nullable(); // 08
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pendaftars');
    }
}