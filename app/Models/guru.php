<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\kelas;

class guru extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'nip',
        'jabatan',
        'id_kelas'
    ];

    public function kelas()
{
    return $this->belongsTo(Kelas::class, 'id_kelas', 'id'); // Perhatikan urutan parameter
}
}