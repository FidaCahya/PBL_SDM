<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JabatanKegiatanModel extends Model
{
    use HasFactory;

    protected $table = 'm_jabatan_kegiatan';
    protected $primaryKey = 'jabatan_id';
    protected $fillable = [
        'jabatan_id',
        'jabatan_kode',
        'jabatan_nama',
        'poin'
    ];
}
