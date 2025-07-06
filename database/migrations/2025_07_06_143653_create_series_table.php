<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('series', function (Blueprint $table) {
            $table->string('id')->primary(); // DUGA APIのシリーズIDを主キーとして保存
            $table->string('name');
            $table->timestamps(); // created_at と updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('series');
    }
};