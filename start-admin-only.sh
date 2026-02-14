#!/bin/bash
# Start ONLY the admin panel (use this when your API is already running elsewhere).
# Run in Terminal:  ./start-admin-only.sh
# Then open:  http://localhost:8000  (or 8002 if 8000 is in use)

cd "$(dirname "$0")"

# Prefer Homebrew PHP if present (common on Mac)
PHP_BIN=$(command -v php 2>/dev/null || /opt/homebrew/bin/php 2>/dev/null || true)
if [ -z "$PHP_BIN" ]; then
  echo "PHP not found. Install PHP (brew install php, or Laravel Herd) and ensure it's in your PATH."
  exit 1
fi

PORT=8000
if lsof -i :8000 &>/dev/null; then
  PORT=8002
  echo "Port 8000 is in use, using 8002 instead."
fi

echo "Starting admin panel on http://localhost:$PORT"
echo "Open that URL in your browser. Press Ctrl+C to stop."
echo ""
"$PHP_BIN" artisan serve --port=$PORT --host=0.0.0.0
