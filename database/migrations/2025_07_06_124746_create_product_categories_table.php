<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_categories', function (Blueprint $table) {
            $table->id(); // 主キーとして自動インクリメントID
            $table->string('product_external_id'); // Productの外部ID (DUGAのproductid)
            $table->string('category_external_id'); // Categoryの外部ID (DUGAのcategory.data.id)
            $table->string('source_asp')->default('DUGA'); // どのASPからのデータか
            $table->timestamps();

            // 外部キー制約（もし参照先のテーブルが準備できたら追加）
            // $table->foreign('product_external_id')->references('productid')->on('products')->onDelete('cascade');
            // $table->foreign('category_external_id')->references('id')->on('categories')->onDelete('cascade');

            // product_external_id と category_external_id の組み合わせをユニークにする
            // ここを修正: 第3引数で短い名前を指定
            $table->unique(['product_external_id', 'category_external_id'], 'prod_cat_unique'); // 'prod_cat_unique' は例です
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_categories');
    }
};