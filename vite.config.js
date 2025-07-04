import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    // ★★★ この server オプションを追加します ★★★
    server: {
        host: '0.0.0.0', // コンテナの全てのIPアドレスからの接続を許可
        port: 5173,     // Viteのデフォルトポートを明示的に指定
        hmr: {
            host: 'localhost', // ホットモジュールリロード (HMR) は localhost で
        },
        watch: {
            usePolling: true // WSL2などの環境でファイルの変更検知がうまくいかない場合
        }
    },
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});