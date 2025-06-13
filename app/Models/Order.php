<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'status',
        'order_date',
        'remarks',
    ];

    public function orderItems()
    {
        return $this->hasMany(Order_items::class, 'order_id');
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }
    
}
