// Laravel Breeze のデフォルトのbootstrap.js (axios等の設定) を読み込む
import './bootstrap';

// Bootstrap JavaScript を読み込む
import * as bootstrap from 'bootstrap'; // Bootstrapモジュール全体をインポート

// Bootstrapをグローバルスコープに公開
window.bootstrap = bootstrap; 

// Alpine.js を読み込む (Laravel Breeze のデフォルト設定)
import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
