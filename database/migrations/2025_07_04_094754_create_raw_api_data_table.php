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
        Schema::create('raw_api_data', function (Blueprint $table) {
            $table->id(); // 自動インクリメントのプライマリキー

            // 修正点1: 外部APIのソース名を保存するカラムを追加
            $table->string('api_source', 255)->comment('APIのソース名 (例: DUGA, FANZAなど)');

            // 修正点2: APIからのユニークな商品IDを保存するカラム
            $table->string('external_id', 255)->unique()->comment('外部APIにおける商品のユニークID');

            // 修正点3: APIから取得した生のJSONデータ全体を保存するカラム
            $table->json('raw_json_data')->comment('APIから取得した生のJSONデータ');

            // 修正点4: データが最後に取得された日時を記録するカラム
            $table->timestamp('fetched_at')->nullable()->comment('APIからデータを取得した日時');

            $table->timestamps(); // created_at と updated_at カラム
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('raw_api_data');
    }
};