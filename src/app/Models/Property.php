<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $table = 'properties';
    protected $primaryKey = 'id_properti';
    public $timestamps = true;

    protected $fillable = [
        'id_mitra',
        'id_kategori',
        'id_lokasi',
        'nama_properti',
        'deskripsi',
        'harga_per_periode',
        'fasilitas',
    ];

    public function mitra()
    {
        return $this->belongsTo(User::class, 'id_mitra');
    }

    public function category()
    {
        return $this->belongsTo(PropertyCategory::class, 'id_kategori', 'id_kategori');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'id_lokasi', 'id_lokasi');
    }

    public function photos()
    {
        return $this->hasMany(PropertyPhoto::class, 'id_properti', 'id_properti');
    }

    public function coverPhoto()
    {
        return $this->hasOne(PropertyPhoto::class, 'id_properti', 'id_properti')->where('is_cover', true);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'id_properti', 'id_properti');
    }

    public function reviews()
    {
        return $this->hasManyThrough(
            Review::class,
            Booking::class,
            'id_properti',
            'id_booking',
            'id_properti',
            'id_booking'
        );
    }
}
