<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;
    protected $table = 'nilai';

    protected $fillable = [
        'siswa_id', 'mapel_id', 'kelas_id', 'guru_id', 'nilai', 'jenis', 'tanggal'
    ];

    public function siswa()
    {
        return $this->belongsTo(\App\Models\Siswa::class, 'siswa_id');
    }
    public function mapel()
    {
        return $this->belongsTo(\App\Models\Mapel::class, 'mapel_id');
    }
    public function kelas()
    {
        return $this->belongsTo(\App\Models\Kelas::class, 'kelas_id');
    }
    public function guru()
    {
        return $this->belongsTo(\App\Models\Guru::class, 'guru_id');
    }
}
