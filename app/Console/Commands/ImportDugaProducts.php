<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\ProcessDugaImport; // 作成したJobクラスをインポート

class ImportDugaProducts extends Command
{
    /**
     * コンソールコマンドの署名。
     * このコマンドを呼び出す際に使用する名前と、オプションを定義します。
     *
     * @var string
     */
    protected $signature = 'import:duga-products 
                            {--limit=100 : 1回のAPIリクエストで取得するアイテム数 (最大100)} 
                            {--batch=1000 : DBに一括保存するアイテムのバッチサイズ} 
                            {--max-items= : 取得・処理するアイテムの最大総数 (テスト/部分インポート用、nullで無制限)}';

    /**
     * コンソールコマンドの説明。
     *
     * @var string
     */
    protected $description = 'DUGA APIから商品をインポートするジョブをディスパッチします。';

    /**
     * コンソールコマンドを実行します。
     *
     * @return int
     */
    public function handle(): int
    {
        // limit オプションのバリデーションと調整
        $limit = (int) $this->option('limit');
        if ($limit > 100 || $limit < 1) {
            $this->warn('The --limit option must be between 1 and 100. Setting to 100.');
            $limit = 100;
        }

        // batch オプションの取得
        $batchSize = (int) $this->option('batch');

        // max-items オプションの取得 (指定がなければnull)
        $maxItems = $this->option('max-items') ? (int) $this->option('max-items') : null;

        // ProcessDugaImport Jobをキューにディスパッチ
        ProcessDugaImport::dispatch($limit, $batchSize, $maxItems);

        $this->info('DUGA商品インポートジョブがキューにディスパッチされました。');
        $this->info('バックグラウンドでジョブを処理するには、`php artisan queue:work`を実行してください。');
        
        return self::SUCCESS; // 成功ステータスを返す
    }
}