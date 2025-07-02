# ベースとなるPHPイメージ
FROM php:8.3-fpm-alpine

# コンテナのタイムゾーンを設定
ARG TIMEZONE=Asia/Tokyo
RUN apk add --no-cache tzdata \
    && cp /usr/share/zoneinfo/${TIMEZONE} /etc/localtime \
    && echo "${TIMEZONE}" > /etc/timezone \
    && rm -rf /var/cache/apk/*

# PHP拡張機能のビルドに必要なシステムライブラリとPHP拡張パッケージを追加
RUN apk add --no-cache \
    libzip-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    zlib-dev \
    icu-dev \
    oniguruma-dev \
    openssl-dev \
    build-base \
    flex \
    bison \
    php83-openssl \
    php83-tokenizer \
    php83-mbstring \
    && rm -rf /var/cache/apk/*

# PHPに必要な拡張機能をインストール (docker-php-ext-install で対応するもの)
RUN docker-php-ext-install pdo pdo_mysql gd exif intl zip bcmath ctype fileinfo

# opcache は設定のインストールと有効化
RUN docker-php-ext-install opcache
RUN docker-php-ext-enable opcache

# Composerをインストール
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Node.js と npm のインストール
RUN apk add --no-cache nodejs-current npm \
    && rm -rf /var/cache/apk/*

# Python関連のインストール
RUN apk add --no-cache python3 py3-pip \
    && rm -rf /var/cache/apk/*
RUN pip3 install mysql-connector-python python-dotenv --break-system-packages

# 作業ディレクトリを設定 (Laravelアプリケーションのルートになります)
WORKDIR /var/www/html

# ローカルのLaravelアプリケーションのファイルをコンテナにコピー
# docker-compose.yml の context がプロジェクトルートに設定されているため、
# これで composer.json を含む全てのファイルがコピーされる
COPY . /var/www/html

# Composerの依存関係をインストール
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Laravelのストレージとキャッシュディレクトリの権限設定
RUN chown -R www-data:www-data storage bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache

# コンテナ起動時にPHP-FPMを実行
CMD ["php-fpm"]