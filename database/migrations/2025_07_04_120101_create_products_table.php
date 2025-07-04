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
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // 主キー

            // DUGA APIから取得する商品データに対応するカラム
            $table->string('productid')->unique()->comment('DUGAの外部商品ID');
            $table->string('title')->comment('商品タイトル');
            $table->text('caption')->nullable()->comment('キャプション');
            $table->string('makername')->nullable()->comment('メーカー名');
            $table->string('url')->nullable()->comment('DUGAサイトの商品URL');
            $table->string('affiliateurl')->nullable()->comment('アフィリエイトURL');
            $table->date('opendate')->nullable()->comment('公開日');
            $table->date('releasedate')->nullable()->comment('リリース日');
            $table->string('itemno')->nullable()->comment('アイテムNo');
            $table->string('price_text')->nullable()->comment('価格テキスト（例: "980円"）');
            $table->integer('price_min')->nullable()->comment('価格（最小値）');
            $table->integer('price_max')->nullable()->comment('価格（最大値）');
            $table->string('volume')->nullable()->comment('ボリューム');
            $table->string('posterimage_large')->nullable()->comment('ポスター画像URL (大)');
            $table->string('jacketimage_large')->nullable()->comment('ジャケット画像URL (大)');
            $table->string('thumbnail_main')->nullable()->comment('メインサムネイル画像URL');
            $table->string('samplemovie_url')->nullable()->comment('サンプル動画URL');
            $table->string('samplemovie_capture')->nullable()->comment('サンプル動画キャプチャURL');
            $table->string('label_id')->nullable()->comment('レーベルID');
            $table->string('label_name')->nullable()->comment('レーベル名');
            $table->string('series_id')->nullable()->comment('シリーズID');
            $table->string('series_name')->nullable()->comment('シリーズ名');
            $table->integer('ranking_total')->nullable()->comment('ランキング総合');
            $table->decimal('review_rating', 3, 2)->nullable()->comment('レビュー平均評価'); // 例: 4.50
            $table->integer('review_count')->nullable()->comment('レビュー数');
            $table->integer('mylist_total')->nullable()->comment('マイリスト登録数');

            $table->timestamps(); // created_at と updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};