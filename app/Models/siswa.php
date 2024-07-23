<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\kelas;

class Siswa extends Model
{
    use HasFactory;

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'nama',
        'noinduk',
        'nisn',
        'id_kelas'
    ];
    
    public function kelas()
{
    return $this->belongsTo(Kelas::class, 'id_kelas', 'id'); // Perhatikan urutan parameter
}
}