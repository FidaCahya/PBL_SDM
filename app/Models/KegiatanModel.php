<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KegiatanModel extends Model
{
    use HasFactory;

    protected $table = 't_kegiatan';
    protected $primaryKey = 'kegiatan_id';
    protected $fillable = [
        'kegiatan_id',
        'jenis_kegiatan_id',
        'nama_kegiatan',
        'deskripsi_kegiatan',
        'bobot_kerja',
        'tanggal_mulai',
        'tanggal_selesai',
        'status' // kolom status sesuai skema
    ];

    public function jenis_kegiatan(): BelongsTo
    {
        return $this->belongsTo(JenisKegiatanModel::class, 'jenis_kegiatan_id', 'jenis_kegiatan_id');
    }
    public function anggota_kegiatan()
    {
        return $this->hasMany(AnggotaKegiatanModel::class, 'kegiatan_id', 'kegiatan_id');
    }
    public function progress_kegiatan()
    {
        return $this->hasMany(ProgressKegiatanModel::class, 'kegiatan_id', 'kegiatan_id');
    }

}
