<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // DBファサードを使用します

return new class extends Migration
{
    /**
     * Run the migrations.
     * `series` テーブルの `id` カラムの型を `varchar` から `BIGINT UNSIGNED` に変更します。
     */
    public function up(): void
    {
        Schema::table('series', function (Blueprint $table) {
            // 現在のプライマリキーを一時的に削除します。
            // キー名が 'PRIMARY' であることを前提としていますが、もしエラーになる場合は
            // phpMyAdminで 'series' テーブルの「インデックス」タブを確認し、正しいキー名を使ってください。
            // 一般的には、Eloquentはデフォルトで 'PRIMARY' を使用します。
            $table->dropPrimary(); // 引数なしで、テーブルのプライマリキーを削除します。
        });

        // ここで直接SQLを使ってカラムの型を変更します。
        // `id` カラムを BIGINT UNSIGNED に変更し、AUTO_INCREMENT と PRIMARY KEY を再設定します。
        // ※ 既存の `id` データが全て数値として有効な文字列であることを前提としています。
        //    もし数値に変換できない文字列が含まれていると、この操作は失敗します。
        DB::statement('ALTER TABLE series MODIFY id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY');
    }

    /**
     * Reverse the migrations.
     * ロールバック時に元の `varchar` 型に戻しますが、**データ損失の可能性が高い**です。
     * このロールバックは開発環境でのみ限定的に使用することを強く推奨します。
     */
    public function down(): void
    {
        Schema::table('series', function (Blueprint $table) {
            // プライマリキーを削除
            $table->dropPrimary();

            // idカラムを元のVARCHAR型に戻す
            // ここもデータ損失のリスクがあります。
            DB::statement('ALTER TABLE series MODIFY id VARCHAR(255) PRIMARY KEY');
        });
    }
};