#!/bin/sh
set -eu

PROJECT_DIR="$(CDPATH= cd -- "$(dirname -- "$0")/.." && pwd)"
cd "$PROJECT_DIR"

timestamp="$(date +%Y%m%d-%H%M%S)"
backup_root="${BACKUP_ROOT:-$PROJECT_DIR/backups}"
backup_dir="$backup_root/$timestamp"

mkdir -p "$backup_dir"

docker compose ps >/dev/null

docker compose exec -T app sh -lc 'cat /var/www/html/storage/database/database.sqlite' > "$backup_dir/database.sqlite"
docker compose exec -T app sh -lc 'cd /var/www/html && tar -czf - storage/app storage/framework storage/logs' > "$backup_dir/storage.tar.gz"

if [ -f "$PROJECT_DIR/.env.docker" ]; then
    cp "$PROJECT_DIR/.env.docker" "$backup_dir/.env.docker"
fi

if [ -d /etc/letsencrypt/live ] && [ -d /etc/letsencrypt/renewal ]; then
    tar -czf "$backup_dir/letsencrypt.tar.gz" /etc/letsencrypt/live /etc/letsencrypt/renewal >/dev/null 2>&1 || true
fi

cat > "$backup_dir/manifest.txt" <<EOF
created_at=$timestamp
project_dir=$PROJECT_DIR
app_url=$(grep '^APP_URL=' .env.docker 2>/dev/null | cut -d= -f2- || true)
ssl_domain=$(grep '^SSL_DOMAIN=' .env.docker 2>/dev/null | cut -d= -f2- || true)
EOF

ln -sfn "$backup_dir" "$backup_root/latest"

echo "Backup created in: $backup_dir"
