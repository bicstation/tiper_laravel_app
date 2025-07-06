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
            // maker_id を追加し、makers テーブルの id を参照する外部キーとして設定
            // nullを許可するのは、既存のデータにmaker_idがない場合があるため
            $table->foreignId('maker_id')->nullable()->constrained('makers')->onDelete('set null')->after('makername');
            // 'makername' カラムは、もし不要であればこのマイグレーションで削除することもできますが、
            // 既存データとの互換性を考慮して、ここでは残します。
            // $table->dropColumn('makername'); // もしmakernameを削除するなら
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['maker_id']); // 外部キー制約を解除
            $table->dropColumn('maker_id'); // maker_id カラムを削除
            // $table->string('makername')->nullable()->after('caption'); // もしmakernameを削除していたら、元に戻す
        });
    }
};