<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $table = 'employees';
    protected $primaryKey = 'id';
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'position_id',
        'branch_id',
        'hire_date',
        'salary',
        'address',
        'date_of_birth',
        'profile_picture',
        'status',
    ];

    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id');
    }
}
