<?php

namespace Campusdigital\CampusCMS\DummySeeder;

use Illuminate\Database\Seeder;
use Campusdigital\CampusCMS\Models\KategoriArtikel;

class DummyKategoriArtikelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        KategoriArtikel::firstOrCreate(['kategori' => 'Tak Berkategori'], ['slug' => 'tak-berkategori', 'id_ka' => 0]);
    }
}
