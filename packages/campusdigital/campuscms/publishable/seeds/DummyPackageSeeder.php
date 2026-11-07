<?php

namespace Campusdigital\CampusCMS\DummySeeder;

use Illuminate\Database\Seeder;
use Campusdigital\CampusCMS\Models\Package;

class DummyPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Package::firstOrCreate(
            ['package_name' => config('faturcms.name')],
            ['package_version' => 'dev', 'package_at' => date('Y-m-d H:i:s'), 'package_up' => date('Y-m-d H:i:s')]
        );
    }
}
