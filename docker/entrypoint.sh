#!/bin/sh
set -eu

APP_DIR="/var/www/html"
RUNTIME_STORAGE="$APP_DIR/storage"
TEMPLATE_STORAGE="/opt/app-template/storage"
READY_FILE="$RUNTIME_STORAGE/framework/.app-ready"
APP_KEY_FILE="$RUNTIME_STORAGE/framework/app.key"

sync_storage() {
    mkdir -p "$RUNTIME_STORAGE"

    if [ -d "$TEMPLATE_STORAGE" ]; then
        cp -a "$TEMPLATE_STORAGE/." "$RUNTIME_STORAGE/"
    fi

    mkdir -p \
        "$RUNTIME_STORAGE/app/public" \
        "$RUNTIME_STORAGE/app/private" \
        "$RUNTIME_STORAGE/database" \
        "$RUNTIME_STORAGE/framework/cache/data" \
        "$RUNTIME_STORAGE/framework/sessions" \
        "$RUNTIME_STORAGE/framework/views" \
        "$RUNTIME_STORAGE/logs" \
        "$APP_DIR/bootstrap/cache"

    chown -R www-data:www-data "$RUNTIME_STORAGE" "$APP_DIR/bootstrap/cache"
}

ensure_app_key() {
    if [ -n "${APP_KEY:-}" ]; then
        return
    fi

    mkdir -p "$(dirname "$APP_KEY_FILE")"

    if [ ! -s "$APP_KEY_FILE" ]; then
        php -r 'echo "base64:".base64_encode(random_bytes(32));' > "$APP_KEY_FILE"
        chown www-data:www-data "$APP_KEY_FILE"
    fi

    export APP_KEY
    APP_KEY="$(cat "$APP_KEY_FILE")"
}

ensure_sqlite_database() {
    if [ "${DB_CONNECTION:-sqlite}" != "sqlite" ]; then
        return
    fi

    db_path="${DB_DATABASE:-$APP_DIR/storage/database/database.sqlite}"
    mkdir -p "$(dirname "$db_path")"

    if [ ! -f "$db_path" ]; then
        touch "$db_path"
    fi

    chown -R www-data:www-data "$(dirname "$db_path")"
}

prepare_application() {
    rm -f "$APP_DIR/public/hot"
    refresh_package_manifest
    php artisan storage:link --force >/dev/null 2>&1 || true
    php artisan migrate --force
    php artisan optimize:clear
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    touch "$READY_FILE"
    chown www-data:www-data "$READY_FILE"
}

wait_for_application() {
    attempts=0

    while [ ! -f "$READY_FILE" ]; do
        attempts=$((attempts + 1))

        if [ "$attempts" -gt 60 ]; then
            echo "Application initialization timed out." >&2
            exit 1
        fi

        echo "Waiting for application bootstrap..." >&2
        sleep 2
    done
}

refresh_package_manifest() {
    rm -f "$APP_DIR/bootstrap/cache/packages.php" "$APP_DIR/bootstrap/cache/services.php"
    php artisan package:discover --ansi
}

sync_storage
ensure_app_key
ensure_sqlite_database

if [ "${1:-}" = "php-fpm" ]; then
    prepare_application
fi

if [ "${1:-}" = "php" ] && [ "${2:-}" = "artisan" ] && [ "${3:-}" = "queue:work" ]; then
    wait_for_application
    refresh_package_manifest
fi

exec "$@"
