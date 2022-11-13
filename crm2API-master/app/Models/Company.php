<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'company',
        'address',
        'address2',
        'website_url',
        'city_id',
        'staff_id',
    ];
}
