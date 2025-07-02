<?php

namespace App\Imports;

use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SiswaImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $nama = $row['nama'] ?? $row['nama_siswa'] ?? null;
        if (!$nama) return null; // skip baris tanpa nama

        $user = User::firstOrCreate(
            ['username' => $row['nis']],
            [
                'nama' => $nama,
                'username' => $row['nis'],
                'role' => 'siswa',
                'password' => $row['nis'] . 'MAN',
            ]
        );

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
