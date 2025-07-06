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
            // series_id カラムが存在しない場合にのみ追加する
            if (!Schema::hasColumn('products', 'series_id')) { // ★この行を追加
                // series_id カラムを追加
                // Seriesテーブルの 'id' を参照する外部キーとして設定
                // onDelete('set null') は、シリーズが削除された場合に、関連する商品のseries_idをNULLにする設定です。
                // もしシリーズが削除されたら商品も削除したい場合は onDelete('cascade') に変更してください。
                // 既に存在する商品データにこのカラムを追加する場合は、nullable() を付けておく方が安全です。
                $table->foreignId('series_id')->nullable()->constrained('series')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // series_id カラムが存在する場合にのみ削除する
            if (Schema::hasColumn('products', 'series_id')) { // ★この行を追加
                // ロールバック時に外部キー制約を削除
                $table->dropForeign(['series_id']);
                // カラムを削除
                $table->dropColumn('series_id');
            }
        });
    }
};