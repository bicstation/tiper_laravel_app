<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\ProcessDugaImport; // ProcessDugaImport ジョブをインポート
use Illuminate\Support\Facades\Log;

class ProcessDugaImportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'process:duga-import
                            {--limit=100 : The number of items to fetch per API request.}
                            {--batchSize=500 : The batch size for database upserts.}
                            {--maxItems= : The maximum number of items to process (null for no limit).}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import product data from DUGA API.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $limit = (int) $this->option('limit');
        $batchSize = (int) $this->option('batchSize');
        $maxItems = $this->option('maxItems') ? (int) $this->option('maxItems') : null;

        $this->info("Dispatching ProcessDugaImport job with limit={$limit}, batchSize={$batchSize}, maxItems=" . ($maxItems ?? 'unlimited') . "...");

        // ジョブをキューにディスパッチ (非同期実行)
        // ProcessDugaImport::dispatch($limit, $batchSize, $maxItems);

        // ジョブを同期的に直接実行する場合 (テスト/デバッグ用)
        // 大量のデータを扱う場合は、上記のようにキューにディスパッチすることを推奨します
        (new ProcessDugaImport($limit, $batchSize, $maxItems))->handle();

        $this->info("ProcessDugaImport job has finished its dispatch/execution command.");
        Log::info("ProcessDugaImport Artisan command completed.");

        return Command::SUCCESS;
    }
}