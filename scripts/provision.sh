#!/usr/bin/env bash
# Server provisioning script for undefipourtim.com
# Ubuntu 24.04, Hetzner Cloud CX22
# Run once via GitHub Actions workflow_dispatch or directly as root.
#
# Required env vars:
#   DOMAIN           e.g. undefipourtim.com
#   WP_ADMIN_EMAIL   e.g. admin@undefipourtim.com
#
# Optional (generated if not set):
#   WP_ADMIN_PASS    (random if unset — printed at end)
#   WP_DB_PASS       (random if unset)
set -euo pipefail

DOMAIN="${DOMAIN:-undefipourtim.com}"
WP_ADMIN_EMAIL="${WP_ADMIN_EMAIL:-admin@${DOMAIN}}"
WP_DB_NAME="wordpress"
WP_DB_USER="wpuser"
WP_DB_PASS="${WP_DB_PASS:-$(openssl rand -base64 24)}"
WP_ADMIN_USER="admin"
WP_ADMIN_PASS="${WP_ADMIN_PASS:-$(openssl rand -base64 16)}"
WP_ROOT="/var/www/html"

echo "==> Updating packages..."
apt-get update -qq
apt-get install -y -qq nginx php8.3 php8.3-fpm php8.3-mysql php8.3-curl php8.3-gd \
    php8.3-mbstring php8.3-xml php8.3-zip php8.3-intl \
    mysql-server certbot python3-certbot-nginx curl unzip git

echo "==> Configuring MySQL..."
mysql -u root <<SQL
CREATE DATABASE IF NOT EXISTS \`${WP_DB_NAME}\` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER IF NOT EXISTS '${WP_DB_USER}'@'localhost' IDENTIFIED BY '${WP_DB_PASS}';
GRANT ALL PRIVILEGES ON \`${WP_DB_NAME}\`.* TO '${WP_DB_USER}'@'localhost';
FLUSH PRIVILEGES;
SQL

echo "==> Installing WP-CLI..."
curl -sO https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar
chmod +x wp-cli.phar
mv wp-cli.phar /usr/local/bin/wp

echo "==> Downloading WordPress..."
mkdir -p "${WP_ROOT}"
wp core download --path="${WP_ROOT}" --allow-root

echo "==> Creating wp-config.php..."
wp config create \
    --path="${WP_ROOT}" \
    --dbname="${WP_DB_NAME}" \
    --dbuser="${WP_DB_USER}" \
    --dbpass="${WP_DB_PASS}" \
    --dbhost="localhost" \
    --allow-root
# Harden: move wp-config above webroot would require Nginx adjustment — skip for now
wp config set WP_DEBUG false --path="${WP_ROOT}" --allow-root
wp config set WP_AUTO_UPDATE_CORE minor --path="${WP_ROOT}" --allow-root

echo "==> Installing WordPress..."
wp core install \
    --path="${WP_ROOT}" \
    --url="https://${DOMAIN}" \
    --title="Un Défi pour Tim" \
    --admin_user="${WP_ADMIN_USER}" \
    --admin_password="${WP_ADMIN_PASS}" \
    --admin_email="${WP_ADMIN_EMAIL}" \
    --skip-email \
    --allow-root

echo "==> Installing plugins..."
wp plugin install polylang advanced-custom-fields --activate --path="${WP_ROOT}" --allow-root

echo "==> Activating theme..."
# Theme is deployed via rsync by GitHub Actions after this script runs.
# Activate once it exists:
# wp theme activate defitim --path="${WP_ROOT}" --allow-root

echo "==> Configuring Nginx..."
cat > /etc/nginx/sites-available/defitim <<NGINX
server {
    listen 80;
    listen [::]:80;
    server_name ${DOMAIN} www.${DOMAIN};
    root ${WP_ROOT};
    index index.php;

    location / {
        try_files \$uri \$uri/ /index.php?\$args;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/run/php/php8.3-fpm.sock;
    }

    location ~ /\.ht {
        deny all;
    }

    location = /xmlrpc.php {
        deny all;
    }

    client_max_body_size 32M;
}
NGINX

ln -sf /etc/nginx/sites-available/defitim /etc/nginx/sites-enabled/defitim
rm -f /etc/nginx/sites-enabled/default
nginx -t && systemctl reload nginx

echo "==> Setting file permissions..."
chown -R www-data:www-data "${WP_ROOT}"
find "${WP_ROOT}" -type d -exec chmod 755 {} \;
find "${WP_ROOT}" -type f -exec chmod 644 {} \;

echo "==> Obtaining SSL certificate..."
certbot --nginx -d "${DOMAIN}" -d "www.${DOMAIN}" \
    --non-interactive --agree-tos --email "${WP_ADMIN_EMAIL}" \
    --redirect

echo "==> Setting up daily backup cron..."
cat > /etc/cron.daily/wp-backup <<CRON
#!/bin/bash
DATE=\$(date +%F)
mysqldump -u ${WP_DB_USER} -p'${WP_DB_PASS}' ${WP_DB_NAME} | gzip > /root/backups/db-\${DATE}.sql.gz
find /root/backups -name 'db-*.sql.gz' -mtime +14 -delete
CRON
chmod +x /etc/cron.daily/wp-backup
mkdir -p /root/backups

echo ""
echo "=============================================="
echo "  Provisioning complete"
echo "=============================================="
echo "  Domain : https://${DOMAIN}"
echo "  WP admin: https://${DOMAIN}/wp-admin"
echo "  User   : ${WP_ADMIN_USER}"
echo "  Pass   : ${WP_ADMIN_PASS}"
echo "  DB pass: ${WP_DB_PASS}"
echo ""
echo "  SAVE THESE CREDENTIALS — they are not stored anywhere else."
echo "=============================================="
