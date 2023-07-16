<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{
    use HasFactory;
    protected $table = 'logs';

    protected $fillable = [
        'user_id',
        'ip',
        'url',
        'method',
        'user_agent',
        'payload',
        'event',
        'extra'
    ];
}
