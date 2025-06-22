#!/bin/sh

# Laravelのキャッシュとログディレクトリのパーミッションを設定
# コンテナ起動時に毎回実行されるようにする
if [ -d /var/www/html/storage ]; then
  chown -R www-data:www-data /var/www/html/storage
  chmod -R 775 /var/www/html/storage
fi

if [ -d /var/www/html/bootstrap/cache ]; then
  chown -R www-data:www-data /var/www/html/bootstrap/cache
  chmod -R 775 /var/www/html/bootstrap/cache
fi

# アプリケーションディレクトリに移動
cd /var/www/html

# php-fpmを起動、または渡されたコマンドを実行
exec "$@"
