#!/usr/bin/env bash
set -e
cd "$(dirname "$0")"
PHP_BIN=php
command -v php >/dev/null 2>&1 || PHP_BIN=/opt/homebrew/bin/php
"$PHP_BIN" artisan serve --port=8000
