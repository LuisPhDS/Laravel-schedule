<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TarefaModel extends Model
{
    use HasFactory;

    protected $table = 'tarefas';

    // config UUID
    public $incrementing = false;
    protected $keyType = 'string';
}
