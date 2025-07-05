<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RawApiData extends Model
{
    use HasFactory;

    // テーブル名を明示的に指定する場合（RawApiDataはLaravelの命名規則から外れるため推奨）
    protected $table = 'raw_api_data'; 

    // 複数代入可能な属性
    protected $fillable = [
        'api_source',
        'external_id',
        'raw_json_data',
        'fetched_at',
    ];

    // 日付として扱う属性
    protected $casts = [
        'fetched_at' => 'datetime',
    ];
}