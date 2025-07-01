# ベースとなるPHPイメージ
FROM php:8.3-fpm-alpine

# コンテナのタイムゾーンを設定
ARG TIMEZONE=Asia/Tokyo
RUN apk add --no-cache tzdata \
    && cp /usr/share/zoneinfo/${TIMEZONE} /etc/localtime \
    && echo "${TIMEZONE}" > /etc/timezone \
    && rm -rf /var/cache/apk/*
    # apk add 後にキャッシュを削除しイメージサイズを削減

# PHP拡張機能のビルドに必要なシステムライブラリを追加
# libzip-dev: zip 拡張の依存
# libpng-dev, libjpeg-turbo-dev, freetype-dev: gd 拡張の依存
# icu-dev: intl 拡張の依存
# zlib-dev: 圧縮関連の拡張の依存
# oniguruma-dev: mbstring 拡張の依存
# openssl-dev: openssl 拡張の依存
# build-base: コンパイルに必要な基本的なツールセット (make, gccなど)
# flex, bison: パーサージェネレーター (tokenizerなどの依存)
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
    && rm -rf /var/cache/apk/*

# PHPに必要な拡張機能をインストール (分割して実行 - tokenizer以外)
RUN docker-php-ext-install pdo
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install opcache
RUN docker-php-ext-install gd
RUN docker-php-ext-install exif
RUN docker-php-ext-install intl
RUN docker-php-ext-install zip
RUN docker-php-ext-install bcmath
RUN docker-php-ext-install ctype
RUN docker-php-ext-install fileinfo
RUN docker-php-ext-install mbstring
# RUN docker-php-ext-install tokenizer # <<< この行を削除します！

# openssl を手動でインストール
RUN set -eux; \
    apk add --no-cache --virtual .build-deps-openssl \
        autoconf \
        build-base \
        libtool \
        openssl-dev \
    ; \
    docker-php-source extract; \
    cd /usr/src/php/ext/openssl; \
    phpize; \
    ./configure --with-openssl; \
    make; \
    make install; \
    docker-php-ext-enable openssl; \
    cd /; \
    docker-php-source delete; \
    apk del .build-deps-openssl

# tokenizer を手動でインストール
RUN set -eux; \
    apk add --no-cache --virtual .build-deps-tokenizer \
        autoconf \
        build-base \
        libtool \
        flex \
        bison \
    ; \
    docker-php-source extract; \
    cd /usr/src/php/ext/tokenizer; \
    phpize; \
    ./configure; \
    make; \
    make install; \
    docker-php-ext-enable tokenizer; \
    cd /; \
    docker-php-source delete; \
    apk del .build-deps-tokenizer

# opcache は個別に有効化
RUN docker-php-ext-enable opcache

# Composerをインストール
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# ===============================================
# Node.js と npm のインストール (フロントエンドビルドに必要)
RUN apk add --no-cache nodejs-current npm \
    && rm -rf /var/cache/apk/*
# ===============================================

# Python関連のインストール
# Alpine Linux のパッケージマネージャー 'apk' を使用
RUN apk add --no-cache python3 py3-pip \
    && rm -rf /var/cache/apk/*

# pip を使ってPythonの依存ライブラリをインストール
# --break-system-packages は、Dockerイメージビルド時にもシステムパッケージ管理の警告を抑制
RUN pip3 install mysql-connector-python python-dotenv --break-system-packages
# ===============================================

# 作業ディレクトリを設定 (Laravelアプリケーションのルートになります)
WORKDIR /var/www/html

# コンテナ起動時にPHP-FPMを実行
CMD ["php-fpm"]