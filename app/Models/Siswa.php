<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';
    protected $fillable = ['user_id', 'kelas_id', 'nis', 'no_hp'];

    // Relasi ke model User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke model Kelas
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    // Relasi ke model Nilai
    public function nilai()
    {
        return $this->hasMany(Nilai::class);
    }

    // Metode untuk menghitung nilai akumulasi
    public function nilaiAkumulasi()
    {
        $totalNilai = $this->nilai()->sum('nilai');
        $jumlahPenilaian = $this->nilai()->count();

        return $jumlahPenilaian > 0 ? $totalNilai / $jumlahPenilaian : 0;
    }
}
