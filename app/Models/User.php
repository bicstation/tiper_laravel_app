<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel; // この行は既にありますね

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    // ... (既存の fillable, hidden, casts メソッドはそのまま) ...

    public function canAccessFilament(): bool
    {
        // 既存のロジックはそのまま
        return $this->hasRole('admin'); 
    }

    // ★追加: FilamentUser インターフェースのもう一つの必須メソッド
    public function canAccessPanel(Panel $panel): bool
    {
        // ここで、特定のパネルへのアクセス権限を制御できます。
        // デフォルトの管理者パネルにアクセスできるかを FilamantUser::canAccessFilament() で
        // すでに制御しているので、ここでは単純に true を返しても問題ありません。
        // もしくは、FilamentUser::canAccessFilament() と同じロジックをここにも記述することもできます。
        return $this->hasRole('admin'); 

        // または、常に true を返す（canAccessFilament で全体のアクセスを制御しているため）
        // return true; 

        // 特定のパネル（例: 'shop' パネル）を対象にする場合
        // return $panel->getId() === 'shop' ? $this->hasRole('shop_manager') : true;
    }
}