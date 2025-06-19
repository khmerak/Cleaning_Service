<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $table = 'services';
    protected $primaryKey = 'id';
    protected $fillable = [
        'service_name',
        'description',
        'price',
        'category_id',
        'image',
        'type',
    ];

    public function service_category()
    {
        return $this->belongsTo(Service_Category::class, 'category_id');
    }
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
