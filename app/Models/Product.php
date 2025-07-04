<?php
// app/Models/Product.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products'; 

    protected $fillable = [
        'productid', 'title', 'caption', 'makername', 'url', 'affiliateurl',
        'opendate', 'releasedate', 'itemno', 'price_text', 'price_min',
        'price_max', 'volume', 'posterimage_large', 'jacketimage_large',
        'thumbnail_main', 'samplemovie_url', 'samplemovie_capture',
        'label_id', 'label_name', 'series_id', 'series_name', 'ranking_total',
        'review_rating', 'review_count', 'mylist_total',
    ];

    protected $casts = [
        'opendate' => 'date',
        'releasedate' => 'date',
    ];
}