<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'title',
        'deal_size',
        'follow_up_date',
        'phone',
        'email',
        'contact_method',
        'notes',
        'stage_id',
        'staff_id',
        'company_id',
    ];
}
