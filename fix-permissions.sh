#!/usr/bin/env bash
# Run once with sudo so Apache (www-data) and your user can both use the app:
#   sudo bash fix-permissions.sh

set -e
ROOT="$(cd "$(dirname "$0")" && pwd)"
SITE="$(basename "$ROOT")"

chown -R www:www "$ROOT/project/storage" "$ROOT/project/bootstrap/cache"
chmod -R 775 "$ROOT/project/storage" "$ROOT/project/bootstrap/cache"

# PHP open_basedir must match this project folder (aaPanel reads .user.ini from site root)
printf 'open_basedir=%s/:/tmp/\n' "$ROOT" > "$ROOT/.user.ini"

# Remove custom /tmp view path — Apache must use storage/framework/views
sed -i '/^VIEW_COMPILED_PATH=/d' "$ROOT/project/.env"

# Use project/.env everywhere
ln -sf "$ROOT/project/.env" "$ROOT/project/vendor/markury/src/.env"

# Recommended Apache config (replaces root .htaccess if you approve)
if [ -f "$ROOT/htaccess.recommended" ]; then
  cp "$ROOT/htaccess.recommended" "$ROOT/.htaccess"
fi

# Load .env from project/ (Laravel default); remove legacy markury env path if present
sed -i "s|useEnvironmentPath([^)]*)|useEnvironmentPath(realpath(__DIR__.'/..'))|" "$ROOT/project/bootstrap/app.php"

# aaPanel expects /www/wwwroot/<domain>/ — symlink when missing (fixes "No input file specified.")
if [ -w /www/wwwroot ] && [ ! -e "/www/wwwroot/${SITE}.local" ]; then
  ln -sfn "$ROOT" "/www/wwwroot/${SITE}.local"
  chown -h www:www "/www/wwwroot/${SITE}.local"
fi

# After storage is writable, prefer file cache/sessions (edit project/.env if needed):
# CACHE_DRIVER=file
# SESSION_DRIVER=file
# LOG_CHANNEL=single

if command -v /etc/init.d/php-fpm-74 >/dev/null 2>&1; then
  /etc/init.d/php-fpm-74 restart || true
fi

echo "Done. Open http://${SITE}.local (or restart PHP 7.4 in aaPanel if the site still errors)."
