<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAddToCart extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $table = 'product_add_to_carts';
    protected $fillable = ['user_id', 'product_id', 'quantity', 'price'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
