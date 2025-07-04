<?php

return [
    'feeds' => [
        'products' => [ // このキーがフィードの名前になります (例: /feed/products)
            'title' => '最新のDUGA作品', // フィードのタイトル
            'url' => '/feed/products', // フィードのURL (これはroutes/web.phpで定義します)
            'description' => 'DUGAで新しく公開された作品の最新情報をお届けします。', // フィードの説明
            'language' => 'ja-JP', // フィードの言語
            'type' => 'rss', // フィードの形式 (rss, atom, json から選択)
            'format' => 'atom', // 日付のフォーマット (これは通常 'atom' で良いです)
            'items' => 'App\Http\Controllers\ProductFeedController@getFeedItems', // ここでデータを取得するメソッドを指定
            'view' => 'feed::feed', // フィードを表示するBladeビュー (デフォルトでOK)
            'cache' => env('FEED_CACHE_MINUTES', 60), // キャッシュ時間（分）
        ],
        // 他のフィードがあればここに追加
    ],
];