<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    // 👇 Add this if your table name is actually `invoices`
    protected $table = 'invoices';

    protected $fillable = [
        'method',
        'order_id',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
