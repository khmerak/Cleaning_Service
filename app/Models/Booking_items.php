<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking_items extends Model
{
    use HasFactory;
    protected $table = 'booking_items';
    protected $primaryKey = 'id';
    protected $fillable = [
        'booking_id',
        'service_id',
        'quantity',
        'price',
        'address',
    ];
}
