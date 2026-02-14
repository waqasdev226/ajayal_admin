#!/usr/bin/env bash
cd "$(dirname "$0")"
php artisan route:list 2>/dev/null | head -5 && echo "Admin app OK" || echo "Run: composer install && php artisan key:generate"
