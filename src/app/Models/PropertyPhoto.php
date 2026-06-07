<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyPhoto extends Model
{
    use HasFactory;

    protected $table = 'property_photos';
    protected $primaryKey = 'id_foto';
    public $timestamps = true;

    protected $fillable = [
        'id_properti',
        'url_foto',
        'urutan',
        'is_cover',
        'object_position',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class, 'id_properti', 'id_properti');
    }
}
