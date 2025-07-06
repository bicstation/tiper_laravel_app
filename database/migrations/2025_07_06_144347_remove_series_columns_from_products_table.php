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
            // series_idとseries_nameカラムを削除
            // カラムが存在しない場合にエラーにならないよう、hasColumnでチェックすることも可能
            if (Schema::hasColumn('products', 'series_id')) {
                $table->dropColumn('series_id');
            }
            if (Schema::hasColumn('products', 'series_name')) {
                $table->dropColumn('series_name');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // downメソッドでは、必要であればカラムを元に戻す定義をします。
            // ただし、ProductSeriesテーブルがメインになるため、通常は空でも問題ありません。
            // 厳密にロールバックしたい場合は以下のように追加します。
            // $table->string('series_id')->nullable()->after('label_name');
            // $table->string('series_name')->nullable()->after('series_id');
        });
    }
};