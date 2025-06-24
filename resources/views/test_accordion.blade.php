{{-- resources/views/test_accordion.blade.php --}}

@extends('layouts.app') {{-- layouts.app をマスターレイアウトとして継承 --}}

@section('title', 'アコーディオンテストページ') {{-- ページのタイトル --}}

@section('content')
<div class="container-fluid bg-white p-4 rounded shadow-sm mt-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light p-3 rounded shadow-sm">
            <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-home me-1"></i>ホーム</a></li>
            <li class="breadcrumb-item active" aria-current="page">
                <i class="fas fa-flask me-1"></i>アコーディオンテスト
            </li>
        </ol>
    </nav>
    <h1 class="mb-4"><i class="fas fa-lightbulb me-2"></i>アコーディオンテストページ</h1>
    <p>このページでは、Bootstrapのアコーディオンコンポーネントが単独で正しく機能するかどうかを確認します。</p>

    <div class="accordion" id="testAccordion">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTestOne" aria-expanded="true" aria-controls="collapseTestOne">
                    アコーディオン項目 #1 (デフォルトで開く)
                </button>
            </h2>
            <div id="collapseTestOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#testAccordion">
                <div class="accordion-body">
                    <strong>これはアコーディオン項目 #1 のボディです。</strong> ここにはコンテンツが配置されます。デフォルトで開いています。
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTestTwo" aria-expanded="false" aria-controls="collapseTestTwo">
                    アコーディオン項目 #2 (デフォルトで閉じる)
                </button>
            </h2>
            <div id="collapseTestTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#testAccordion">
                <div class="accordion-body">
                    <strong>これはアコーディオン項目 #2 のボディです。</strong> クリックすると開閉します。
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingThree">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTestThree" aria-expanded="false" aria-controls="collapseTestThree">
                    アコーディオン項目 #3 (デフォルトで閉じる)
                </button>
            </h2>
            <div id="collapseTestThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#testAccordion">
                <div class="accordion-body">
                    <strong>これはアコーディオン項目 #3 のボディです。</strong> ここもクリックで開閉します。
                </div>
            </div>
        </div>
    </div>

    <p class="mt-4">このアコーディオンが期待通りに開閉するか確認してください。</p>

    <div class="mt-5 p-3 border rounded bg-light">
        <h4>Bootstrap JavaScript テスト</h4>
        <p>以下のボタンにカーソルを合わせるか、タップしてみてください。</p>
        <button type="button" class="btn btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="これはツールチップです">
            ツールチップテストボタン
        </button>
        <p class="mt-2">ツールチップが表示されれば、BootstrapのJavaScriptが動作しています。</p>
    </div>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Bootstrapのツールチップを初期化
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>
@endpush
