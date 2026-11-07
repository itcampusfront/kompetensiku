<?php

namespace Campusdigital\CampusCMS\DummySeeder;

use Illuminate\Database\Seeder;
use Campusdigital\CampusCMS\Models\KategoriUser;

class DummyKategoriUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        KategoriUser::firstOrCreate(['kategori' => 'Lain-Lain'], ['slug' => 'lain-lain', 'id_ku' => 0]);
    }
}
