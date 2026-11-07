<?php

namespace Campusdigital\CampusCMS\DummySeeder;

use Illuminate\Database\Seeder;
use Campusdigital\CampusCMS\Models\Folder;

class DummyRootFolderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Folder::firstOrCreate(
            ['folder_dir' => '/'],
            ['id_user' => 1, 'folder_nama' => '/', 'folder_kategori' => 0, 'folder_parent' => 0, 'folder_icon' => '', 'folder_voucher' => '', 'folder_at' => date('Y-m-d H:i:s'), 'folder_up' => date('Y-m-d H:i:s')]
        );
    }
}
