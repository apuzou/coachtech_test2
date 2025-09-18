# mogitate 商品管理システム

商品の一覧表示、検索、ソート、編集・削除機能を持つ Web アプリケーションです。

## 環境構築

### 前提条件

- Docker
- Docker Compose

### セットアップ手順

1. **リポジトリのクローン**

```bash
git clone git@github.com:apuzou/coachtech_test2.git
cd coachtech_test2
```

2. **Docker コンテナのビルド・起動**

```bash
docker-compose up -d --build
```

3. **Laravel の初期設定**

```bash
# Composerの依存関係をインストール
docker-compose exec php composer install

# 環境設定ファイルの作成
docker-compose exec php cp .env.example .env

# アプリケーションキーの生成
docker-compose exec php php artisan key:generate

# ストレージリンクの作成
docker-compose exec php php artisan storage:link
```

4. **データベースのマイグレーション・シーディング**

```bash
# マイグレーション実行
docker-compose exec php php artisan migrate

# シーダー実行（季節データと商品データの投入）
docker-compose exec php php artisan db:seed
```

## 使用技術(実行環境)

- **PHP**: 8.1
- **Laravel**: 8.75
- **MySQL**: 8.0.26
- **Nginx**: 1.21.1
- **Docker**: Docker Compose 環境
- **Composer**: 依存関係管理

## ER 図

<img width="521" height="551" alt="test2_ER図" src="https://github.com/user-attachments/assets/1a52a68b-7a6a-4b0a-a872-5c6670bc071b" />

## URL

- **開発環境**: http://localhost/products
- **phpMyAdmin**: http://localhost:8080
  - ユーザー名: laravel_user
  - パスワード: laravel_pass
