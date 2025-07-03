<x-filament-panels::page>
    {{-- Filamentのページコンポーネントでラップ --}}

    {{-- ページヘッダーはFilamentが自動で表示するので不要 --}}

    <div class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
        <div class="fi-section-header px-6 py-4">
            <h3 class="fi-section-header-heading text-lg font-semibold text-gray-950 dark:text-white">サマリー</h3>
        </div>
        <div class="fi-section-content p-6">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <div class="fi-stats-overview-card rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 p-4">
                    <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">総ページビュー数</h4>
                    <p class="text-3xl font-bold tracking-tight text-gray-950 dark:text-white mt-1">{{ number_format($pageData['totalPageViews']) }}</p>
                </div>
                <div class="fi-stats-overview-card rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 p-4">
                    <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">総ユニーク訪問者数</h4>
                    <p class="text-3xl font-bold tracking-tight text-gray-950 dark:text-white mt-1">{{ number_format($pageData['uniqueVisitors']) }}</p>
                </div>
                <div class="fi-stats-overview-card rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 p-4">
                    <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">直近24時間のページビュー</h4>
                    <p class="text-3xl font-bold tracking-tight text-gray-950 dark:text-white mt-1">{{ number_format($pageData['viewsLast24Hours']) }}</p>
                </div>
                <div class="fi-stats-overview-card rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 p-4">
                    <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">直近24時間のユニーク訪問者</h4>
                    <p class="text-3xl font-bold tracking-tight text-gray-950 dark:text-white mt-1">{{ number_format($pageData['uniqueVisitorsLast24Hours']) }}</p>
                </div>
            </div>
        </div>
    </div>


    <div class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 mt-6">
        <div class="fi-section-header px-6 py-4">
            <h3 class="fi-section-header-heading text-lg font-semibold text-gray-950 dark:text-white">直近30日間の日別ページビュー</h3>
        </div>
        <div class="fi-section-content p-6">
            <div class="fi-ta-content overflow-x-auto rounded-xl">
                <table class="fi-ta-table w-full divide-y divide-gray-200 text-sm dark:divide-white/5">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-white/5">
                            <th class="fi-ta-header px-3 py-3.5 text-left text-sm font-semibold text-gray-950 dark:text-white">日付</th>
                            <th class="fi-ta-header px-3 py-3.5 text-left text-sm font-semibold text-gray-950 dark:text-white">ページビュー数</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 whitespace-nowrap dark:divide-white/5">
                        @forelse($pageData['dailyPageViews'] as $data)
                            <tr class="fi-ta-row transition duration-75 hover:bg-gray-50 dark:hover:bg-white/5">
                                <td class="fi-ta-cell px-3 py-3.5">{{ $data->date }}</td>
                                <td class="fi-ta-cell px-3 py-3.5">{{ number_format($data->views) }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="2" class="fi-ta-cell px-3 py-3.5 text-center text-gray-500 dark:text-gray-400">データがありません。</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 mt-6">
        <div class="fi-section-header px-6 py-4">
            <h3 class="fi-section-header-heading text-lg font-semibold text-gray-950 dark:text-white">アクセスが多いページ (Top 10)</h3>
        </div>
        <div class="fi-section-content p-6">
            <div class="fi-ta-content overflow-x-auto rounded-xl">
                <table class="fi-ta-table w-full divide-y divide-gray-200 text-sm dark:divide-white/5">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-white/5">
                            <th class="fi-ta-header px-3 py-3.5 text-left text-sm font-semibold text-gray-950 dark:text-white">URL</th>
                            <th class="fi-ta-header px-3 py-3.5 text-left text-sm font-semibold text-gray-950 dark:text-white">ページビュー数</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 whitespace-nowrap dark:divide-white/5">
                        @forelse($pageData['topPages'] as $page)
                            <tr class="fi-ta-row transition duration-75 hover:bg-gray-50 dark:hover:bg-white/5">
                                <td class="fi-ta-cell px-3 py-3.5"><a href="{{ $page->url }}" target="_blank" rel="noopener noreferrer" class="text-primary-600 hover:underline">{{ Str::limit($page->url, 80) }}</a></td>
                                <td class="fi-ta-cell px-3 py-3.5">{{ number_format($page->views) }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="2" class="fi-ta-cell px-3 py-3.5 text-center text-gray-500 dark:text-gray-400">データがありません。</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 mt-6">
        <div class="fi-section-header px-6 py-4">
            <h3 class="fi-section-header-heading text-lg font-semibold text-gray-950 dark:text-white">IPアドレス別のアクセス数 (Top 10)</h3>
        </div>
        <div class="fi-section-content p-6">
            <div class="fi-ta-content overflow-x-auto rounded-xl">
                <table class="fi-ta-table w-full divide-y divide-gray-200 text-sm dark:divide-white/5">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-white/5">
                            <th class="fi-ta-header px-3 py-3.5 text-left text-sm font-semibold text-gray-950 dark:text-white">IPアドレス</th>
                            <th class="fi-ta-header px-3 py-3.5 text-left text-sm font-semibold text-gray-950 dark:text-white">アクセス数</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 whitespace-nowrap dark:divide-white/5">
                        @forelse($pageData['topIps'] as $ip)
                            <tr class="fi-ta-row transition duration-75 hover:bg-gray-50 dark:hover:bg-white/5">
                                <td class="fi-ta-cell px-3 py-3.5">{{ $ip->ip_address }}</td>
                                <td class="fi-ta-cell px-3 py-3.5">{{ number_format($ip->views) }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="2" class="fi-ta-cell px-3 py-3.5 text-center text-gray-500 dark:text-gray-400">データがありません。</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</x-filament-panels::page>