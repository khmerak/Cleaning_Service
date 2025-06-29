<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $fillable = [
        'category_name',
        'description',
    ];
    /**
     * Get the products associated with the category.
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}