#!/bin/bash
# Run the admin panel using Docker (no PHP needed on your Mac).
# Requires: Docker Desktop installed and running.
# Then open:  http://localhost:8000

cd "$(dirname "$0")"

if ! command -v docker &>/dev/null; then
  echo "Docker not found. Install Docker Desktop: https://www.docker.com/products/docker-desktop/"
  exit 1
fi

echo "Starting admin panel with Docker..."
echo "First run may take 1–2 minutes (installing PHP deps)."
echo "Then open:  http://localhost:8000"
echo ""

docker compose up --build
