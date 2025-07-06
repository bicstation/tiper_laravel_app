<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany; // ★追加

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        // 他のfillableプロパティ
    ];

    /**
     * このカテゴリに属する商品を取得します。
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}