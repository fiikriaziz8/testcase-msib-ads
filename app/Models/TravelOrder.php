<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TravelOrder extends Model
{
    use HasFactory;
    protected $fillable = [
        'travel_id',
        'user_id',
        'namaTravel',
        'asal',
        'tujuan',
        'harga',
        'waktuBerangkat',
        'tanggalOrder',
    ];

    public function travel()
    {
        return $this->belongsTo(Travel::class, 'travel_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
