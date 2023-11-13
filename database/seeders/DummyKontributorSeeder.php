<?php

namespace Campusdigital\CampusCMS\DummySeeder;

use Illuminate\Database\Seeder;
use Campusdigital\CampusCMS\Models\Kontributor;

class DummyKontributorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Kontributor::firstOrCreate(['kontributor' => '-'], ['slug' => '-', 'id_kontributor' => 0]);
    }
}
