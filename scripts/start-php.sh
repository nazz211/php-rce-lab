#!/usr/bin/env bash
set -euo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
cd "$ROOT_DIR"

PHP_BIN="${PHP_BIN:-}"
if [ -z "$PHP_BIN" ]; then
  for candidate in php php8.2 php8.1 php8.0 php8; do
    if command -v "$candidate" >/dev/null 2>&1; then
      PHP_BIN="$(command -v "$candidate")"
      break
    fi
  done
fi

if [ -z "$PHP_BIN" ] || [ ! -x "$PHP_BIN" ]; then
  echo "PHP executable not found. Install PHP CLI first, then retry PM2." >&2
  exit 127
fi

exec "$PHP_BIN" -S 127.0.0.1:8000 -t app
