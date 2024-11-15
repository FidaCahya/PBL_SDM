<?php 

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProgressKegiatanModel extends Model
{
    use HasFactory;

    protected $table = 't_progress_kegiatan';
    protected $primaryKey = 'progress_kegiatan_id';
    protected $fillable = [
        'progress_kegiatan_id',
        'kegiatan_id',
        'anggota_kegiatan_id',
        'update_progress'
    ];

    /**
     * Relasi ke model KegiatanModel.
     */
    public function kegiatan()
    {
        return $this->belongsTo(KegiatanModel::class, 'kegiatan_id', 'kegiatan_id');
    }

    /**
     * Relasi ke model AnggotaKegiatanModel.
     */
    public function anggota_kegiatan(): BelongsTo
    {
        return $this->belongsTo(AnggotaKegiatanModel::class, 'anggota_kegiatan_id', 'anggota_kegiatan_id');
    }

    public function jabatan(): BelongsTo
    {
        return $this->belongsTo(JabatanKegiatanModel::class, 'jabatan_id', 'jabatan_id');
    }

    // Model AnggotaKegiatan
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
