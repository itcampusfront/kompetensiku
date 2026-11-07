<?php

namespace Campusdigital\CampusCMS\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class UsersImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new User([
            'nama_user' => $row['nama_user'],
            'username'     => $row['username'],
            'email'    => $row['email'],
            'password' => bcrypt(12345678),
            'tanggal_lahir' => '',
            'jenis_kelamin' => $row['jenis_kelamin'],
            'nomor_hp' => $row['nomor_hp'],
            'reference' =>  $row['reference'],
            'user_kategori' => 0,
            'status'=>1,
            'foto' => '',
            'role' => 7,
            'is_admin' => 0,
            'saldo' => 0,
            'email_verified' => 1,
            'instansi' => $row['instansi'],
            'last_visit' => null,
            'register_at' => date('Y-m-d H:i:s'),
        ]);
    }

    // public function rules(): array
    // {
    //     return [
    //         'email' => Rule::in(['patrick@maatwebsite.nl']),

    //          // Above is alias for as it always validates in batches
    //          '*.email' => Rule::in(['patrick@maatwebsite.nl']),
    //     ];
    // }

}
