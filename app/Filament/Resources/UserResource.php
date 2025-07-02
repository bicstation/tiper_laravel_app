<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash; // ★この行を追加しました！

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    // protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationIcon = 'heroicon-o-users'; // アイコンをユーザーグループに変更

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // ★★★ ここから以下の行が追加・修正された部分です ★★★
                Forms\Components\TextInput::make('name')
                    ->required() // 必須項目にする
                    ->maxLength(255), // 最大文字数
                Forms\Components\TextInput::make('email')
                    ->email() // メールアドレス形式のバリデーション
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true), // ユニークにする（編集時は自分自身を無視）
                Forms\Components\TextInput::make('password')
                    ->password() // パスワード入力フィールド
                    ->dehydrateStateUsing(fn (string $state): string => Hash::make($state)) // パスワードをハッシュ化して保存
                    ->dehydrated(fn (?string $state): bool => filled($state)) // フォームが空でなければ保存
                    ->required(fn (string $operation): bool => $operation === 'create'), // 新規作成時のみ必須
                // ★★★ ここまでが追加・修正された部分です ★★★
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable() // 検索可能にする
                    ->sortable(), // ソート可能にする
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->dateTime() // 日時形式で表示
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true), // デフォルトで非表示、表示切り替え可能に
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}