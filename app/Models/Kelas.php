<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';
    protected $fillable = ['nama_kelas'];

    // Relasi ke model Siswa
    public function siswa()
    {
        return $this->hasMany(Siswa::class);
    }

    // Relasi ke model Guru (jika ada guru yang terkait dengan kelas)
    public function guru()
    {
        return $this->hasMany(Guru::class);
    }
}
