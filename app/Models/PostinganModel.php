<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostinganModel extends Model
{
    use HasFactory;

    protected $table = 'tb_postingan';

    protected $guarded = ['id'];
}
