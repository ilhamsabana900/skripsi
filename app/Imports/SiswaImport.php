<?php

namespace App\Imports;

use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;

class SiswaImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Cek apakah user sudah ada berdasarkan NIS
        $user = User::firstOrCreate(
            ['username' => $row['nis']],
            [
                'nama' => $row['nama'],
                'username' => $row['nis'],
                'role' => 'siswa',
                'password' => $row['nis'] . 'MAN', // plain text password
            ]
        );

        // Cek apakah siswa sudah ada berdasarkan user_id
        return Siswa::firstOrCreate(
            ['user_id' => $user->id],
            [
                'kelas_id' => $row['kelas_id'],
                'nis' => $row['nis'],
                'no_hp' => $row['no_hp'] ?? null,
            ]
        );
    }
}
