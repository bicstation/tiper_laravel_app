<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_series', function (Blueprint $table) {
            $table->string('product_external_id');
            $table->string('series_external_id');
            $table->string('source_asp')->default('DUGA');
            $table->timestamps();

            // 複合プライマリキーまたはユニークキー
            $table->unique(['product_external_id', 'series_external_id'], 'prod_series_unique');

            // 外部キー制約（必要であれば）
            // $table->foreign('product_external_id')->references('productid')->on('products')->onDelete('cascade');
            // $table->foreign('series_external_id')->references('id')->on('series')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_series');
    }
};