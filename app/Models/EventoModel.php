<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventoModel extends Model
{
    use HasFactory;

    protected $table = 'eventos';

    // config UUID
    public $incrementing = false;
    protected $keyType = 'string';
}
