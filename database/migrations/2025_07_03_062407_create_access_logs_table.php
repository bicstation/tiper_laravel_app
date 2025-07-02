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
        Schema::create('access_logs', function (Blueprint $table) {
            $table->id();
            $table->string('url')->index(); // アクセスされたURL (検索効率を上げるためにインデックスを追加)
            $table->string('ip_address')->nullable(); // アクセス元のIPアドレス
            $table->string('user_agent', 500)->nullable(); // ユーザーエージェント (ブラウザ、OS情報)
            $table->string('referrer', 500)->nullable(); // 参照元URL
            $table->timestamps(); // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('access_logs');
    }
};