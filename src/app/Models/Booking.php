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

    /**
     * Mendapatkan durasi pemesanan dalam hari.
     */
    public function getDurationInDaysAttribute(): int
    {
        if (!$this->tanggal_mulai || !$this->tanggal_selesai) {
            return 0;
        }
        $start = \Carbon\Carbon::parse($this->tanggal_mulai);
        $end = \Carbon\Carbon::parse($this->tanggal_selesai);
        return (int) max(1, $start->diffInDays($end) + 1);
    }

    /**
     * Menghitung total harga sewa berdasarkan properti dan durasi.
     */
    public function calculateTotalPrice(): float
    {
        if (!$this->property) {
            return 0.0;
        }
        return (float) ($this->property->harga_per_hari * $this->duration_in_days);
    }

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
