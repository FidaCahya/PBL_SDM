<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisKegiatanModel extends Model
{
    use HasFactory;

    protected $table = 'm_jenis_kegiatan';
    protected $primaryKey = 'jenis_kegiatan_id';
    public $timestamps = true; // Menggunakan timestamps

    protected $fillable = [
        'jenis_kegiatan_id',
        'nama_jenis_kegiatan'
    ];
}
