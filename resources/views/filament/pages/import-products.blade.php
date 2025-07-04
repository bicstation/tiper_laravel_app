<x-filament-panels::page>
    <x-filament-panels::form wire:submit="submit">
        {{ $this->form }}

        <div class="mt-4">
            {{-- アクションボタンを配置 --}}
            @foreach ($this->getHeaderActions() as $action)
                {{ $action }}
            @endforeach
        </div>
    </x-filament-panels::form>

    {{-- ここを x-filament::card に修正 --}}
    <x-filament::card class="mt-4">
        <h3 class="text-lg font-semibold mb-2">Import Status (Check Logs)</h3>
        <p class="text-sm text-gray-600 dark:text-gray-400">
            インポート処理はバックグラウンドで実行されます。進捗状況はLaravelのログファイル (<code class="text-xs">storage/logs/laravel.log</code>) で確認してください。
            または、<a href="{{ url('/telescope/jobs') }}" target="_blank" class="text-primary-600 hover:text-primary-700 font-medium">Laravel Telescope</a> を使用している場合は、Jobのキュー状況を確認できます。
        </p>
        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">
            キューワーカーが実行されていることを確認してください: <code class="text-xs">php artisan queue:work</code>
        </p>
    </x-filament::card>
</x-filament-panels::page>