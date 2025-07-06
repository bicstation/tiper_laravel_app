<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSeries extends Model
{
    use HasFactory;

    protected $table = 'product_series';

    protected $fillable = [
        'product_external_id',
        'series_external_id',
        'source_asp',
    ];

    // Productへのリレーションシップ
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_external_id', 'productid');
    }

    // Seriesへのリレーションシップ
    public function series()
    {
        return $this->belongsTo(Series::class, 'series_external_id', 'id');
    }
}