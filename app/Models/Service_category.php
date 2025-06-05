<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service_category extends Model
{
    use HasFactory;
    protected $table = 'service_categories';
    protected $primaryKey = 'id';
    protected $fillable = [
        'service_category_name',
        'description',
    ];

    public function services()
    {
        return $this->hasMany(Service::class, 'category_id');
    }
}
