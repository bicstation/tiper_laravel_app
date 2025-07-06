<?php
// app/Models/Product.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany; // ★追加：多対多のリレーション用

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    // Laravelのデフォルト主キーが'id'ではない場合、以下を追記
    // protected $primaryKey = 'productid'; // もしproductidが主キーならコメント解除

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

    // ★追加：Categoryモデルとの多対多リレーション
    // 'product_category' は中間テーブルの名前を想定しています。
    // もし中間テーブル名が異なる場合は、第二引数で指定してください。例: ->belongsToMany(Category::class, 'your_pivot_table_name');
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    // ★追加：Makerモデルとのリレーション（makernameがあるが、maker_idもあればより良い）
    // もし maker_id カラムがあり、Maker モデルが存在するなら以下を追加できます
    // public function maker(): BelongsTo
    // {
    //     return $this->belongsTo(Maker::class, 'maker_id'); // もしProductテーブルにmaker_idがあるなら
    // }

    // ★シリーズリレーション（もしseries_idが外部キーで、Seriesモデルが存在するなら）
    // 現状series_idとseries_nameがproductsテーブルにあるので、
    // 厳密なリレーションは必須ではありませんが、将来的にSeriesモデルを作成するなら定義
    // public function series(): BelongsTo
    // {
    //     return $this->belongsTo(Series::class, 'series_id');
    // }
}