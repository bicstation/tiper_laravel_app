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
                const bsOffcanvas = bootstrap.Offcanvas.getInstance(myCustomSidebar);
                if (bsOffcanvas && bsOffcanvas._isShown) {
                    mainContent.style.marginLeft = '280px';
                }
            }
        });
    }
});