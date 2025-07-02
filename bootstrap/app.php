<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // webミドルウェアグループにLogPageViewミドルウェアを追加します
        $middleware->web(append: [
            \App\Http\Middleware\LogPageView::class,
        ]);

        // 必要であれば、他のミドルウェアグループ（例: api）もここで定義できます
        // $middleware->api(append: [
        //     // ...
        // ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();