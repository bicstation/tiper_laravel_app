README: 開発環境のセットアップと起動方法
このプロジェクトは Docker Compose を利用して開発環境を構築します。
初回起動時、または環境をクリーンアップして再構築する際は、以下の手順に従ってください。

前提条件
Docker Desktop (または Docker Engine & Docker Compose CLI) がインストールされ、実行されていること。

Windows の場合は WSL2 が有効になっていることを推奨します。

Git がインストールされていること (プロジェクトのクローン用)。

1. プロジェクトのクローン (初回のみ)
Bash

git clone [あなたのリポジトリのURL]
cd [あなたのプロジェクトディレクトリ名] # 例: cd tiper_laravel_app
2. 環境設定ファイルの準備
Laravel の環境設定ファイル .env を準備します。
通常、.env.example をコピーして .env.local を作成します。
開発環境では DB_DATABASE, DB_USERNAME, DB_PASSWORD などの設定が重要です。

Bash

cp .env.example .env.local
.env.local ファイルを開き、必要に応じてデータベースの接続情報などを確認・調整してください。
(重要) Vite開発サーバーがDockerコンテナ内で正しく動作するために、以下の行を追加または確認してください。

コード スニペット

# .env.local

# ... (既存の設定) ...

# Vite開発サーバーの設定 (開発環境でのみ必要)
VITE_DEV_SERVER_HOST=0.0.0.0
VITE_DEV_SERVER_PORT=5173
3. Dockerイメージのビルドとコンテナの起動
プロジェクトのルートディレクトリで以下のコマンドを実行し、Dockerイメージをビルドしてコンテナを起動します。
初回ビルド時は時間がかかります。

Bash

docker compose build --no-cache # 新しいイメージを確実にビルド
docker compose up -d           # コンテナをバックグラウンドで起動
4. 依存関係のインストールと初期設定
PHP (Laravel) コンテナ内で作業を行います。

a. PHPコンテナのシェルに入る
Bash

docker exec -it tiper_laravel_app_php bash
注意: もし bash で入れない場合、sh で入り、apk add --no-cache bash (Alpineの場合) または apt-get update && apt-get install -y bash (Debian/Ubuntuの場合) で bash をインストールしてください。
(※ 今回のトラブルシューティングで docker/php/Dockerfile に bash インストールが追加されていれば、この問題は発生しないはずです。)

b. Composerの依存関係をインストール
Laravelアプリケーションに必要なPHPの依存ライブラリをインストールします。

Bash

composer install
c. データベースのマイグレーションとデータのシード
データベースのテーブルを作成し、テストデータを投入します。

Bash

php artisan migrate         # データベーステーブルを作成
php artisan db:seed         # テストデータを投入 (必要であれば)
d. Laravelのストレージとキャッシュの権限設定
Bash

php artisan storage:link    # ストレージへのシンボリックリンクを作成 (必要な場合)
php artisan optimize:clear  # Laravelのキャッシュをクリア
e. PHPコンテナのシェルから出る
上記作業が完了したら、コンテナのシェルを終了します。

Bash

exit
5. フロントエンドアセットの準備と開発サーバーの起動
別のターミナルウィンドウを開き、プロジェクトのルートディレクトリでフロントエンドアセットをコンパイルします。
開発中はファイルの変更をリアルタイムで反映させるために、Vite開発サーバーを起動したままにします。

a. npmパッケージのインストール (初回のみ)
Bash

npm install
b. Vite開発サーバーの起動
Bash

npm run dev
注意: このコマンドを実行したターミナルは、開発中は開いたままにしておく必要があります。

6. ブラウザで確認
すべての手順が完了したら、以下のURLにアクセスしてアプリケーションを確認します。

Laravelアプリケーションのトップページ: http://localhost/ または http://tipers.live/ (hostsファイル設定済みの場合)

PhpMyAdmin: http://localhost:8081/

RSSフィード: http://localhost/feed/products

これで、すべてのサービスが正常に動作し、開発を開始できるはずです。















Dockerで起動する方法
最初に、行うこと
filamintのユーザー登録
php artisan make:filament-user

git pull origin main

cd ~/tiper_laravel_app
docker-compose down && docker-compose up --build -d

docker-compose down
docker-compose up -d --build

Git-GitHubにプッシュする方法
このリポジトリに変更を加え、GitHubにプッシュするには、以下の手順を実行してください。

git config --global user.email "bicstation@gmail.com"                        
git config --global user.name "bicstation"

1. リポジトリをクローンする
まず、このリポジトリをローカル環境にクローンします。ターミナルまたはコマンドプロンプトで以下のコマンドを実行してください。

Bash

git clone [リポジトリのURL]
例：

Bash

git clone https://github.com/your-username/your-repository-name.git
2. 変更を加える
クローンしたリポジトリのディレクトリに移動し、必要な変更を加えます。

Bash

cd [リポジトリ名]
3. 変更をステージングする
変更をコミットするために、まず変更をステージングエリアに追加します。

すべての変更を追加する場合:
Bash

git add .
特定のファイルを追加する場合:
Bash

git add [ファイル名]
4. 変更をコミットする
ステージングした変更をコミットします。コミットメッセージは、行った変更がわかるように具体的に記述してください。

Bash

git commit -m "あなたのコミットメッセージ"
例：

Bash

git commit -m "READMEにプッシュ方法を追加"
5. GitHubにプッシュする
ローカルの変更をGitHubのリモートリポジトリにプッシュします。通常はmainまたはmasterブランチにプッシュします。

Bash

git push origin [ブランチ名]
例：

Bash

git push origin main
READMEに含めると良い追加情報
上記の基本的な手順に加えて、以下のような情報をREADMEに含めると、より親切なドキュメントになります。

前提条件: Gitがインストールされていること、GitHubアカウントを持っていることなどを記載すると良いでしょう。
新しいブランチでの作業: 直接mainブランチにプッシュするのではなく、新しいブランチを作成して作業し、プルリクエストを送るワークフローを推奨する場合、その手順も記載します。
git checkout -b [新しいブランチ名]
git push origin [新しいブランチ名]
GitHub上でのプルリクエスト作成方法への言及
コンフリクトの解決: 複数人で開発を行う場合、コンフリクトが発生する可能性があるため、その解決方法について簡単に触れるか、関連ドキュメントへのリンクを提供すると良いでしょう。
認証情報: 最初にプッシュする際にGitHubのユーザー名とパスワード（またはPersonal Access Token）の入力を求められることについて言及しておくと、ユーザーが戸惑わずに済みます。
この例文を参考に、あなたのリポジトリの状況に合わせて適宜調整してご活用ください。

