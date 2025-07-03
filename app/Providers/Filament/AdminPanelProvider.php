<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

// ★★★ 追加するuseステートメント ★★★
use Filament\Navigation\NavigationBuilder;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
// ★★★ これらも追加または確認 ★★★
use App\Filament\Pages\Analytics; // アクセス解析ページを明示的にuse
use App\Filament\Resources\UserResource; // Usersリソースを明示的にuse

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            // discoverResources, discoverPages は通常残しておきますが、
            // ナビゲーションの表示は下の navigation() メソッドで完全に制御します。
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
                // Analyticsページは navigation() メソッドで追加するのでここからは削除
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }

    // ★★★ navigation() メソッドを修正 ★★★
    protected function navigation(): NavigationBuilder
    {
        return NavigationBuilder::make()
            ->items([
                // 1. ダッシュボード
                NavigationItem::make('Dashboard')
                    ->url(fn (): string => Pages\Dashboard::getUrl())
                    ->icon('heroicon-o-home')
                    ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.pages.dashboard')), // アクティブ状態を正しく表示

                // 2. '管理'グループ
                NavigationGroup::make('管理')
                    ->items([
                        // Usersリソースのナビゲーションアイテム
                        // UserResource::getNavigationItem() はUserResourceが生成されている場合にのみ使用
                        UserResource::getNavigationItem(),

                        // アクセス解析ページ
                        Analytics::getNavigationItem(),

                        // phpMyAdminへの外部リンク
                        NavigationItem::make('phpMyAdmin')
                            ->url(env('PHPMYADMIN_URL', 'http://localhost:8080'), shouldOpenInNewTab: true)
                            ->icon('heroicon-o-server') // アイコンは適宜変更
                            ->sort(99), // 他のアイテムより下に表示されるようにソート値を高くする
                    ]),
                // ここに他のグループやアイテムを追加できます
            ]);
    }
    // ★★★ navigation() メソッドの修正ここまで ★★★
}