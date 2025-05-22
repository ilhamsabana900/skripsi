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
        // Asumsi urutan kolom: nama, nis, no_hp, kelas (nama kelas)
        $kelas = Kelas::where('nama_kelas', $row[3])->first();
        // Buat user baru untuk siswa jika belum ada
        $email = $row[1].'@siswa.com'; // email dari NIS
        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'nama' => $row[0], // ganti 'name' jadi 'nama'
                'username' => $row[1], // tambahkan username dari NIS
                'password' => bcrypt('password123'), // password default
                'role' => 'siswa',
            ]
        );
        return new Siswa([
            'nama' => $row[0],
            'nis' => $row[1],
            'no_hp' => $row[2],
            'kelas_id' => $kelas ? $kelas->id : null,
            'user_id' => $user->id,
        ]);
    }
}
