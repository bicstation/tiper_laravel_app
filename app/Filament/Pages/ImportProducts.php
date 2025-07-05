<?php

namespace App\Filament\Pages;

use Filament\Actions\Action;
use Filament\Pages\Page;
use App\Jobs\ProcessDugaImport; // Jobをインポート
use Filament\Notifications\Notification; // 通知用
use Filament\Forms\Components\TextInput; // フォームコンポーネント
use Filament\Forms\Concerns\InteractsWithForms; // フォーム用トレイト
use Filament\Forms\Contracts\HasForms; // フォーム用インターフェース
use Illuminate\Support\Facades\Log; 

class ImportProducts extends Page implements HasForms
{
    use InteractsWithForms; // フォーム用トレイトを使用

    protected static ?string $navigationIcon = 'heroicon-o-arrow-path'; // ナビゲーションアイコン
    protected static ?string $navigationGroup = 'Import & Sync'; // ナビゲーショングループ
    protected static ?string $navigationLabel = 'API Products Import'; // ナビゲーションラベル

    protected static string $view = 'filament.pages.import-products';

    // フォームの状態を保持するプロパティ
    public int $limit = 100;
    public int $batchSize = 500; // ★ここを1000から500に変更
    public ?int $maxItems = null;

    // ページロード時にフォームを初期化
    protected function getFormSchema(): array
    {
        return [
            TextInput::make('limit')
                ->label('API Request Limit (max 100)')
                ->numeric()
                ->minValue(1)
                ->maxValue(100)
                ->default(100)
                ->extraAttributes(['class' => 'w-full']),
            TextInput::make('batchSize')
                ->label('Database Batch Size')
                ->numeric()
                ->minValue(1)
                ->default(1000)
                ->extraAttributes(['class' => 'w-full']),
            TextInput::make('maxItems')
                ->label('Max Items to Import (Optional)')
                ->numeric()
                ->minValue(1)
                ->nullable() // 空を許可
                ->extraAttributes(['class' => 'w-full']),
        ];
    }

    // アクションを定義（ボタンなど）
    protected function getHeaderActions(): array
    {
        return [
            Action::make('importDuga')
                ->label('Import DUGA Products (Queue)')
                ->color('primary')
                ->action(function () {
                    try {
                        // フォームの値をバリデートし、取得
                        $data = $this->form->getState();

                        // Jobをディスパッチ
                        ProcessDugaImport::dispatch(
                            $data['limit'],
                            $data['batchSize'],
                            $data['maxItems']
                        );

                        Notification::make()
                            ->title('DUGA Product Import started!')
                            ->body('The import job has been dispatched to the queue. It will run in the background.')
                            ->success()
                            ->send();

                    } catch (\Exception $e) {
                        Notification::make()
                            ->title('Import Failed')
                            ->body('An error occurred: ' . $e->getMessage())
                            ->danger()
                            ->send();
                        Log::error('Filament DUGA import dispatch error: ' . $e->getMessage());
                    }
                })
                ->form([ // アクションがクリックされたときに表示されるフォーム
                    // ここに設定項目（limit, batchSize, maxItems）を定義することもできるが、
                    // ページ上に直接フォームを置いた方が使いやすいので、ここでは省略
                ]),
            // FANZAやSOKMILのインポートボタンもここに追加可能
            // Action::make('importFanza')->label('Import FANZA Products (Queue)')...
        ];
    }
}