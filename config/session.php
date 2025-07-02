<?php

use Illuminate\Support\Str;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Session Driver
    |--------------------------------------------------------------------------
    |
    | This option controls the default session "driver" that will be used on
    | requests. By default, we use the lightweight "file" driver which works
    | well for most applications. Drivers are file, cookie, database, APC,
    | memcached, and redis.
    |
    */

    'driver' => env('SESSION_DRIVER', 'file'), // ★ここが env('SESSION_DRIVER', 'file') であることを確認

    /*
    |--------------------------------------------------------------------------
    | Session Lifetime
    |--------------------------------------------------------------------------
    |
    | Here you may specify the number of minutes that the session should be
    | allowed to remain idle before it expires. The session will not expire
    | if the user continues to actively make requests while the application
    | is active and the given minutes will be reset on each fresh request.
    |
    */

    'lifetime' => env('SESSION_LIFETIME', 120),

    /*
    |--------------------------------------------------------------------------
    | Session Encrypt Data
    |--------------------------------------------------------------------------
    |
    | This option allows you to easily specify that all of your session
    | data should be encrypted before it is stored. All encryption is run
    | on an AES-256 cipher and utilizes the encryption key.
    |
    */

    'encrypt' => env('SESSION_ENCRYPT', false),

    /*
    |--------------------------------------------------------------------------
    | Session File Location
    |--------------------------------------------------------------------------
    |
    | When using the "file" session driver, we need a location where the
    | session files may be stored. A default has been provided, but you
    | are free to change it to any directory you wish.
    |
    | This location must be writable by the web server.
    |
    */

    'files' => storage_path('framework/sessions'),

    /*
    |--------------------------------------------------------------------------
    | Session Database Connection
    |--------------------------------------------------------------------------
    |
    | When using the "database" session driver, you may specify a connection
    | that should be used to store your sessions. When this option is null,
    | the default database connection will be used.
    |
    */

    'connection' => env('SESSION_CONNECTION'), // ★ここが env('SESSION_CONNECTION') であることを確認

    /*
    |--------------------------------------------------------------------------
    | Session Database Table
    |--------------------------------------------------------------------------
    |
    | When using the "database" session driver, you may specify the table
    | that should be utilized to store your sessions. This table must first
    | be created by a migration run by your application's database.
    |
    */

    'table' => 'sessions',

    /*
    |--------------------------------------------------------------------------
    | Session Cache Store
    |--------------------------------------------------------------------------
    |
    | When using the "cache" driver, you may specify a cache store that should
    | be utilized to store your sessions. When this option is null, the
    | default cache store will be utilized for session storage.
    |
    */

    'store' => null,

    /*
    |--------------------------------------------------------------------------
    | Session Sweeping Lottery
    |--------------------------------------------------------------------------
    |
    | Some session drivers must be manually cleaned to remove old records from
    | storage. Here are the chances to clean the session if a garbage sweep
    | should occur. This will disable the session garbage collection.
    |
    */

    'lottery' => [2, 100],

    /*
    |--------------------------------------------------------------------------
    | Session Cookie Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify the name of the cookie that Laravel will use for
    | your session. By default, we will use the name of the application for
    | this, plus a SHA-256 hash of the application name.
    |
    */

    'cookie' => env(
        'SESSION_COOKIE',
        Str::slug(env('APP_NAME', 'laravel'), '_').'_session'
    ),

    /*
    |--------------------------------------------------------------------------
    | Session Cookie Path
    |--------------------------------------------------------------------------
    |
    | The session cookie path determines the path for which the cookie will
    | be regarded as available. Typically, this will be the root path of
    | your application but you are free to change it.
    |
    */

    'path' => '/',

    /*
    |--------------------------------------------------------------------------
    | Session Cookie Domain
    |--------------------------------------------------------------------------
    |
    | Here you may change the domain of the cookie used to store the session
    | ID when the session driver is set to "cookie". The domain should be
    | set to your website's primary domain.
    |
    */

    'domain' => env('SESSION_DOMAIN'),

    /*
    |--------------------------------------------------------------------------
    | HTTPS Only Cookies
    |--------------------------------------------------------------------------
    |
    | By default, Laravel will only send session cookies over HTTP (not HTTPS).
    | However, if your application runs on HTTPS only, then you may set this
    | value to true to ensure that the cookie is only ever sent over HTTPS.
    |
    */

    'secure' => env('SESSION_SECURE_COOKIE', false),

    /*
    |--------------------------------------------------------------------------
    | HTTP Only Cookies
    |--------------------------------------------------------------------------
    |
    | By default, Laravel will only send session cookies over HTTP (not HTTPS).
    | However, if your application runs on HTTPS only, then you may set this
    | value to true to ensure that the cookie is only ever sent over HTTPS.
    |
    */

    'http_only' => true,

    /*
    |--------------------------------------------------------------------------
    | Same-Site Cookie Mode
    |--------------------------------------------------------------------------
    |
    | This option determines how your cookies behave when cross-site requests
    | are made. The "lax" setting provides a good balance between security
    | and convenience. You may want to set this to "strict" for stricter
    | security, or "none" if you are operating on multiple domains.
    |
    | For more information: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Set-Cookie/SameSite#lax
    |
    | Supported: "lax", "strict", "none", null
    |
    */

    'same_site' => 'lax',

    /*
    |--------------------------------------------------------------------------
    | Partitioned Cookies
    |--------------------------------------------------------------------------
    |
    | When enabled, session cookies will be marked with the "Partitioned" CSRF
    | attribute. This attribute tells browsers to partition the cookie store
    | by top-level site, preventing the cookie from being sent in a cross-site
    | context.
    |
    | This is intended to prevent cross-site tracking, but will require
    | users to log in again on your site if they navigate from an embedded
    | context.
    |
    */

    'partitioned' => env('SESSION_PARTITIONED_COOKIES', false),

];
