# ベースとなるPHPイメージ
FROM php:8.3-fpm-alpine

# コンテナのタイムゾーンを設定
ARG TIMEZONE=Asia/Tokyo
RUN apk add --no-cache tzdata \
    && cp /usr/share/zoneinfo/${TIMEZONE} /etc/localtime \
    && echo "${TIMEZONE}" > /etc/timezone

# PHP拡張機能のビルドに必要なシステムライブラリを追加
# icu-dev は intl 拡張機能の依存ライブラリです。
RUN apk add --no-cache \
    libzip-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    zlib-dev \
    icu-dev \
    && rm -rf /var/cache/apk/*

# PHPに必要な拡張機能をインストール
# intl 拡張機能を追加します。
RUN docker-php-ext-install pdo pdo_mysql opcache gd exif intl \
    && docker-php-ext-enable opcache

# Composerをインストール
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# ===============================================
# Node.js と npm のインストール
RUN apk add --no-cache nodejs npm
# ===============================================

# Python関連のインストール
# Alpine Linux のパッケージマネージャー 'apk' を使用
RUN apk add --no-cache python3 py3-pip

# pip を使ってPythonの依存ライブラリをインストール
# --break-system-packages は、Dockerイメージビルド時にもシステムパッケージ管理の警告を抑制
RUN pip3 install mysql-connector-python python-dotenv --break-system-packages
# ===============================================

# 作業ディレクトリを設定 (Laravelアプリケーションのルートになります)
WORKDIR /var/www/html

# コンテナ起動時にPHP-FPMを実行
CMD ["php-fpm"]