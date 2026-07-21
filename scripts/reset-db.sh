#!/usr/bin/env bash

set -euo pipefail

docker compose exec backend php artisan migrate:fresh --seed --force
