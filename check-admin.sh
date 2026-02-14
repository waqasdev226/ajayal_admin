#!/bin/bash
# Run this in Terminal to see why the admin panel might not start.
# Usage:  ./check-admin.sh

cd "$(dirname "$0")"

echo "=== 1. Checking PHP ==="
if command -v php &>/dev/null; then
  php -v
else
  echo "PHP NOT FOUND. Install PHP first:"
  echo "  - Mac: brew install php"
  echo "  - Or install Laravel Herd: https://herd.laravel.com"
  exit 1
fi

echo ""
echo "=== 2. Checking port 8000 ==="
if lsof -i :8000 &>/dev/null; then
  echo "Port 8000 is IN USE. Another app is using it."
  echo "We'll use port 8002 instead in the start script."
else
  echo "Port 8000 is free."
fi

echo ""
echo "=== 3. Checking Laravel (admin panel) ==="
if php artisan --version 2>&1; then
  echo "Laravel is OK."
else
  echo "Laravel failed to run. Fix the error above (e.g. run: composer install)"
  exit 1
fi

echo ""
echo "=== 4. Next step ==="
echo "Run:  ./start-admin-only.sh"
echo "Then open in browser:  http://localhost:8000"
echo "(If 8000 was in use, the script will use http://localhost:8002)"
