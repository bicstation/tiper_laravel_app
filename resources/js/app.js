// Laravel Breeze のデフォルトのbootstrap.js (axios等の設定) を読み込む
import './bootstrap';

// Bootstrap JavaScript を読み込む
import * as bootstrap from 'bootstrap'; // Bootstrapモジュール全体をインポート

// Bootstrapをグローバルスコープに公開 (これにより、他のスクリプトからも `bootstrap` オブジェクトが使えるようになる)
window.bootstrap = bootstrap; 

// Alpine.js を読み込む (Laravel Breeze のデフォルト設定)
import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// ★ここから、HTMLから移動したカスタムJavaScriptコード★
document.addEventListener('DOMContentLoaded', function() {
    const myCustomSidebar = document.getElementById('myCustomSidebar');
    const mainContent = document.querySelector('main');

    if (myCustomSidebar && mainContent) {
        myCustomSidebar.addEventListener('show.bs.offcanvas', function () {
            // オフキャンバス表示時にメインコンテンツの左マージンを調整 (mdサイズ以上の場合のみ)
            if (window.innerWidth >= 768) { 
                mainContent.style.marginLeft = '280px'; 
            }
        });
        myCustomSidebar.addEventListener('hide.bs.offcanvas', function () {
            mainContent.style.marginLeft = '0'; 
        });
        
        // 画面サイズ変更時の対応
        window.addEventListener('resize', function() {
            if (window.innerWidth < 768) { 
                mainContent.style.marginLeft = '0';
            } else { 
                // BootstrapのOffcanvasインスタンスを取得
                const bsOffcanvas = bootstrap.Offcanvas.getInstance(myCustomSidebar);
                if (bsOffcanvas && bsOffcanvas._isShown) { 
                    mainContent.style.marginLeft = '280px';
                }
            }
        });
    }
});
// ★ここまで、HTMLから移動したカスタムJavaScriptコード★
