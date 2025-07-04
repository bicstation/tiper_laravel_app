<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
// あなたの新しいコマンドクラスをここにインポートします
use App\Console\Commands\ImportDugaProducts; // この行を追加または確認

class Kernel extends ConsoleKernel
{
    /**
     * アプリケーションが提供するArtisanコマンド。
     *
     * @var array
     */
    protected $commands = [
        // ここに新しいコマンドクラスを追加します
        ImportDugaProducts::class, // この行を追加または確認
    ];

    /**
     * アプリケーションのコマンドスケジュールを定義します。
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule): void
    {
        // スケジュール化されたタスクが必要な場合にここに記述します
        // 例: $schedule->command('import:duga-products --limit=100 --batch=100')->daily();
    }

    /**
     * アプリケーションのコマンドを登録します。
     *
     * @return void
     */
    protected function commands(): void
    {
        // Commandsディレクトリ内のすべてのコマンドを自動的にロードします
        $this->load(__DIR__.'/Commands');

        // コンソールルートファイルをロードします
        require base_path('routes/console.php');
    }
}