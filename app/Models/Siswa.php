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
    public function nilaiAkumulasi($mapel_id = null)
    {
        $query = $this->nilai();
        if ($mapel_id) {
            $query->where('mapel_id', $mapel_id);
        }
        $harian = clone $query;
        $ujian = clone $query;

        $harianList = $harian->where('jenis', 'harian')->pluck('nilai');
        $ujianList = $ujian->where('jenis', 'ujian')->pluck('nilai');

        $avgHarian = $harianList->count() > 0 ? $harianList->sum() / $harianList->count() : 0;
        $avgUjian = $ujianList->count() > 0 ? $ujianList->sum() / $ujianList->count() : 0;

        return round(($avgHarian * 0.7) + ($avgUjian * 0.3), 2);
    }
}
