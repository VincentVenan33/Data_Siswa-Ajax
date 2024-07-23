<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\guru;
use App\Models\siswa;

class kelas extends Model
{
    use HasFactory;
    protected $table = 'kelas';
    protected $fillable = [
        'nama',
        'jurusan'
    ];

    public function guru()
    {
        return $this->hasMany(guru::class, 'id_kelas', 'id');
    }

    public function siswa()
    {
        return $this->hasMany(siswa::class, 'id_kelas', 'id');
    }
}