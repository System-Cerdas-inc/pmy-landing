<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaketVisibility extends Model
{
    use HasFactory;

    protected $table = 'tb_paket_visibility';

    protected $guarded = ['id'];
}
