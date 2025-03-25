<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardPaket extends Model
{
    use HasFactory;

    protected $table = 'tb_card_paket';

    protected $fillable = [
        'title',
    ];
}
