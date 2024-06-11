<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UsersModel extends Authenticatable
{
    use HasFactory;

    protected $table = 'tb_users';
    protected $fillable = [
        'full_name', 'email', 'password',
    ];

    protected $hidden = [
        'password'
    ];
}
