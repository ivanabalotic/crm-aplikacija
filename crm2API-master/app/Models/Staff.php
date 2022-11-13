<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// use Illuminate\Foundation\Auth\Staff as Authenticatable;
// use Illuminate\Notifications\Notifiable;

class Staff extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
        'manager_id',
    ];

    protected $hidden = [
        // 'password',
        'remember_token',
    ];
}
