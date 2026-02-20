#!/bin/bash
# Start admin panel + API backend locally. Run this in your terminal (PHP must be in PATH).
# If your API is already running, use ./start-admin-only.sh instead.
# In another terminal run: npm run dev  (for Vite assets)

set -e
cd "$(dirname "$0")"

if ! command -v php &>/dev/null; then
  echo "PHP not found. Install PHP (e.g. brew install php, or use Laravel Herd) and ensure it's in your PATH."
  exit 1
fi

echo "Starting API backend on http://localhost:8001 ..."
php api_ajayal/artisan serve --port=8001 &
API_PID=$!

echo "Starting admin panel on http://localhost:8000 ..."
php artisan serve --port=8000 &
ADMIN_PID=$!

cleanup() {
  kill $API_PID $ADMIN_PID 2>/dev/null
  exit 0
}
trap cleanup SIGINT SIGTERM

echo ""
echo "Admin panel:  http://localhost:8000"
echo "API backend:  http://localhost:8001"
echo "Press Ctrl+C to stop both servers."
wait
