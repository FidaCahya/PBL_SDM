<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Casts\Attribute;

class UserModel extends  Authenticatable
{
    use HasFactory;

    protected $table = 'm_user';
    protected $primaryKey = 'user_id';
    protected $fillable = [
        'user_id',
        'username',
        'password',
        'nama',
        'level_id',
        'profile_picture',    
    ];
    protected $hidden = ['password']; //jangan di tampilkan saat select
    protected $casts = ['password' => 'hashed']; //casting password agar otomatis di hash

    public function level(): BelongsTo
    {
        return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
    }
     //mendapatkan nama role
    public function getRoleName(): string
    {
        return $this->level->level_name;
    }
    //cek apa user punya role
    public function hashRole($role): bool
    {
        return $this->level->level_kode == $role;
    }
    public function image(): Attribute
    {
        return Attribute::make(
            get:fn($image) =>url('/storage/posts' . $image),
        );
        
    }
}
