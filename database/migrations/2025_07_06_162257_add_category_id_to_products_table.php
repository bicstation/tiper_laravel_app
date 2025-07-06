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
        Schema::table('products', function (Blueprint $table) {
            // category_id カラムが存在しない場合にのみ追加する
            if (!Schema::hasColumn('products', 'category_id')) { // ★この行を追加
                // category_id カラムを追加し、外部キーとして設定します。
                // `categories` テーブルの `id` を参照します。
                // カテゴリが削除された場合に、関連する商品の `category_id` を NULL に設定します。
                // 既存のデータがある場合でも安全に実行できるよう、`nullable()` を指定します。
                $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // category_id カラムが存在する場合にのみ削除する
            if (Schema::hasColumn('products', 'category_id')) { // ★この行を追加
                // ロールバック時に外部キー制約を削除します。
                $table->dropForeign(['category_id']);
                // その後、`category_id` カラムを削除します。
                $table->dropColumn('category_id');
            }
        });
    }
};