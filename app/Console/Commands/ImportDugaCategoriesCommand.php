<?php
// app/Console/Commands/ImportDugaCategoriesCommand.php
namespace App\Console\Commands;

use App\Jobs\ProcessDugaImport;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ImportDugaCategoriesCommand extends Command
{
    protected $signature = 'duga:import-categories'; // このコマンド名を使います
    protected $description = 'Manually import DUGA categories and products for testing/debugging.';

    public function handle()
    {
        $this->info('Starting DUGA categories and products import...');
        Log::info('ImportDugaCategoriesCommand: Starting import process.');

        // ProcessDugaImport のコンストラクタに引数が必要なので渡します
        // 必要に応じて、ここで適切な値（例: 少なめのlimitやmaxItemsでテスト）を設定してください
        $limit = 10; // 例: 10件だけ取得
        $batchSize = 10; // 例: 10件ごとに保存
        $maxItems = 100; // 例: 最大100件で停止

        try {
            $job = new ProcessDugaImport($limit, $batchSize, $maxItems);
            $job->handle(); // ジョブの handle メソッドを直接呼び出す

            $this->info('DUGA categories and products import completed successfully.');
            Log::info('ImportDugaCategoriesCommand: Import process completed successfully.');

        } catch (\Exception $e) {
            $this->error('An error occurred during DUGA import: ' . $e->getMessage());
            Log::error('ImportDugaCategoriesCommand: An error occurred: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
        }

        return Command::SUCCESS;
    }
}