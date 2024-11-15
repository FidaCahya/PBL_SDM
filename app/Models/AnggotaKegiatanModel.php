<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnggotaKegiatanModel extends Model
{
    protected $table = 't_anggota_kegiatan';
    protected $primaryKey = 'anggota_kegiatan_id';
    protected $fillable = [
        'anggota_kegiatan_id',
        'user_id',
        'kegiatan_id',
        'jabatan_id',
    ];

    public function kegiatan(): BelongsTo
    {
        return $this->belongsTo(KegiatanModel::class, 'kegiatan_id', 'kegiatan_id');
    }

    public function jabatan(): BelongsTo
    {
        return $this->belongsTo(JabatanKegiatanModel::class, 'jabatan_id', 'jabatan_id');
    }
    public function user(): BelongsTo
    {
    return $this->belongsTo(UserModel::class, 'user_id', 'user_id');
    }
    public function progress()
    {
        return $this->hasOne(ProgressKegiatanModel::class, 'anggota_kegiatan_id', 'anggota_kegiatan_id');
    }

    
}
