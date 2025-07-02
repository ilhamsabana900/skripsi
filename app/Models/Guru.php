<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;
    protected $table = 'gurus';

    protected $fillable = ['nip', 'nama', 'email', 'mapel_id', 'user_id'];

    // Relasi ke mapel (gunakan nama mapel, tapi tetap sediakan alias lama untuk backward compatibility)
    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'mapel_id');
    }
    // Alias agar $guru->mapels tetap tidak error (sementara)
    public function mapels()
    {
        return $this->mapel();
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
