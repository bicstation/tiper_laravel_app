<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maker extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    /**
     * このメーカーが持つ商品を取得
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'maker_id', 'id');
    }
}