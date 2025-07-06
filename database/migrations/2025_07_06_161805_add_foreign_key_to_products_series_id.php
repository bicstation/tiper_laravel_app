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
            // series_id カラムは既に存在することを前提に、外部キー制約のみを追加
            // constrained('series') で 'series' テーブルの 'id' を参照します
            // onDelete('set null') は、参照元のシリーズが削除された場合に、このseries_idをNULLにする設定
            $table->foreign('series_id')->references('id')->on('series')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // ロールバック時に外部キー制約を削除
            $table->dropForeign(['series_id']);
        });
    }
};