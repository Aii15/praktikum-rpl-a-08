<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'bookings';
    protected $primaryKey = 'id_booking';
    public $timestamps = true;

    protected $fillable = [
        'id_properti',
        'id_user',
        'tanggal_mulai',
        'tanggal_selesai',
        'status_booking',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class, 'id_properti', 'id_properti');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function review()
    {
        return $this->hasOne(Review::class, 'id_booking', 'id_booking');
    }
}
