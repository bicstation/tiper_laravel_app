<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>簡易アクセス解析</title>
    <style>
        body { font-family: 'Arial', sans-serif; margin: 20px; background-color: #f4f4f4; color: #333; }
        .container { max-width: 900px; margin: auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        h1, h2 { color: #0056b3; border-bottom: 2px solid #eee; padding-bottom: 10px; margin-top: 20px; }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .stat-card { background: #e9f5ff; padding: 15px; border-radius: 5px; text-align: center; }
        .stat-card h3 { margin: 0 0 10px 0; color: #007bff; }
        .stat-card p { font-size: 2em; font-weight: bold; margin: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        ul { list-style-type: none; padding: 0; }
        li { margin-bottom: 5px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>簡易アクセス解析レポート</h1>

        <div class="stats-grid">
            <div class="stat-card">
                <h3>総ページビュー数</h3>
                <p>{{ number_format($totalPageViews) }}</p>
            </div>
            <div class="stat-card">
                <h3>総ユニーク訪問者数</h3>
                <p>{{ number_format($uniqueVisitors) }}</p>
            </div>
            <div class="stat-card">
                <h3>直近24時間のページビュー</h3>
                <p>{{ number_format($viewsLast24Hours) }}</p>
            </div>
            <div class="stat-card">
                <h3>直近24時間のユニーク訪問者</h3>
                <p>{{ number_format($uniqueVisitorsLast24Hours) }}</p>
            </div>
        </div>

        <h2>直近30日間の日別ページビュー</h2>
        <table>
            <thead>
                <tr>
                    <th>日付</th>
                    <th>ページビュー数</th>
                </tr>
            </thead>
            <tbody>
                @forelse($dailyPageViews as $data)
                    <tr>
                        <td>{{ $data->date }}</td>
                        <td>{{ number_format($data->views) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="2">データがありません。</td></tr>
                @endforelse
            </tbody>
        </table>

        <h2>アクセスが多いページ (Top 10)</h2>
        <table>
            <thead>
                <tr>
                    <th>URL</th>
                    <th>ページビュー数</th>
                </tr>
            </thead>
            <tbody>
                @forelse($topPages as $page)
                    <tr>
                        <td><a href="{{ $page->url }}" target="_blank" rel="noopener noreferrer">{{ Str::limit($page->url, 80) }}</a></td>
                        <td>{{ number_format($page->views) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="2">データがありません。</td></tr>
                @endforelse
            </tbody>
        </table>

        <h2>IPアドレス別のアクセス数 (Top 10)</h2>
        <table>
            <thead>
                <tr>
                    <th>IPアドレス</th>
                    <th>アクセス数</th>
                </tr>
            </thead>
            <tbody>
                @forelse($topIps as $ip)
                    <tr>
                        <td>{{ $ip->ip_address }}</td>
                        <td>{{ number_format($ip->views) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="2">データがありません。</td></tr>
                @endforelse
            </tbody>
        </table>

    </div>
</body>
</html>