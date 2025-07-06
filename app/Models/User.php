<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles; // Spatieのロール機能を使うために必要
use Filament\Models\Contracts\FilamentUser; // Filamentユーザーの契約を実装
use Filament\Panel; // Filamentのパネルオブジェクトを扱うために必要

class User extends Authenticatable implements FilamentUser // FilamentUserインターフェースを実装
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles; // HasRolesトレイトを使用

    /**
     * マスアサインメント可能な属性。
     * ユーザー作成時や更新時に一括で値を代入できるカラムを指定します。
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',     // ユーザー名
        'email',    // メールアドレス
        'password', // パスワード
    ];

    /**
     * モデルの配列化時に隠蔽されるべき属性。
     * JSONレスポンスなどで表示したくない機密性の高い情報を隠します。
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * キャストする必要がある属性。
     * データベースから取得した値を特定のデータ型に変換します。
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime', // メール検証日時をDateTimeオブジェクトとして扱う
        'password' => 'hashed',            // パスワードをハッシュ化済みとして扱う
    ];

    /**
     * Filamentのデフォルトパネルにユーザーがアクセスできるかどうかを決定します。
     * このメソッドはFilamentのルートアクセスチェックに使用されます。
     *
     * @return bool
     */
    public function canAccessFilament(): bool
    {
        // ユーザーが 'admin' ロールを持っている場合にのみ、Filamentへのアクセスを許可します。
        // SpatieのhasRole()メソッドを使用しています。
        return $this->hasRole('admin');
    }

    /**
     * 指定されたFilamentパネルにユーザーがアクセスできるかどうかを決定します。
     * 複数のFilamentパネルが存在する場合に、パネルごとのアクセス制御を行います。
     *
     * @param  \Filament\Panel  $panel
     * @return bool
     */
    public function canAccessPanel(Panel $panel): bool
    {
        // 現在の実装では、どのパネルに対しても 'admin' ロールを持つユーザーのみアクセスを許可します。
        // canAccessFilament() と同じロジックを適用することで、一元的なアクセス制御が可能です。
        return $this->hasRole('admin');

        // ==== 発展的な利用例（コメントアウトされています） ====
        // もし将来的に複数のFilamentパネル（例: 'shop' パネル、'blog' パネルなど）を導入し、
        // パネルごとに異なるアクセス権限を設定したい場合は、以下のコメントアウトされた例のようにロジックを拡張できます。
        // 例: 'shop' パネルには 'shop_manager' ロールが必要で、それ以外のパネルには 'admin' ロールが必要な場合
        // return $panel->getId() === 'shop'
        //     ? $this->hasRole('shop_manager') // 'shop' パネルの場合
        //     : $this->hasRole('admin');       // その他のパネルの場合
    }
}