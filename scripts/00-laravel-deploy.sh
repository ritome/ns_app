#!/usr/bin/env bash

# エラー発生時にスクリプトを停止
set -e

echo "🚀 Starting deployment process..."

# ストレージディレクトリの権限を設定
echo "📁 Setting storage permissions..."
chmod -R 755 /var/www/html/storage
chmod -R 755 /var/www/html/bootstrap/cache

# .envファイルが存在しない場合は作成
if [ ! -f "/var/www/html/.env" ]; then
    echo "📝 Creating .env file..."
    cp /var/www/html/.env.example /var/www/html/.env
fi

echo "🔑 Generating application key..."
php artisan key:generate --force

echo "📦 Installing Composer dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction

echo "🔄 Running database migrations..."
php artisan migrate --force

echo "📝 Caching configurations..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "⚡ Publishing Livewire assets..."
php artisan livewire:publish --assets

echo "🔗 Creating storage link..."
php artisan storage:link

echo "✨ Optimizing application..."
php artisan optimize

echo "🎉 Deployment completed successfully!"
