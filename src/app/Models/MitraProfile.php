<?php

namespace App\Models;
/* model MitraProfile: data profil tambahan untuk mitra */

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MitraProfile extends Model
{
    use HasFactory;

    protected $table = 'mitra_profiles';

    protected $fillable = [
        'user_id',
        'nama_mitra',
        'ktp',
        'rekening_bank',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
