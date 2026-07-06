<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $table = 'lokasi';
    protected $primaryKey = 'id_lokasi';
    public $timestamps = true;

    protected $fillable = [
        'nama_lokasi',
        'alamat_detail',
        'kota',
        'provinsi',
        'kode_pos',
    ];

    public function properties()
    {
        return $this->hasMany(Property::class, 'id_lokasi', 'id_lokasi');
    }
}
