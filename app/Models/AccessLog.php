<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessLog extends Model
{
    use HasFactory;

    // 以下のカラムへの一括代入を許可する
    protected $fillable = [
        'url',
        'ip_address',
        'user_agent',
        'referrer',
    ];
}