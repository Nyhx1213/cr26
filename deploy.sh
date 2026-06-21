#!/bin/bash
set -e

REPO_URL="https://github.com/Nyhx1213/cr26"
APP_ROOT="/var/www"
PUBLIC_ROOT="/var/www/public"
COMPOSER_BIN="/usr/local/bin/composer"
NPM_BIN="/home/administrateur/.nvm/versions/node/v24.13.0/bin/npm"
ENV_SOURCE="/home/administrateur/.env"

VERSION=$(git ls-remote $REPO_URL HEAD | cut -f1)

RELEASE_DIR="$APP_ROOT/releases/$VERSION"

echo "Version = $VERSION"
echo "Dossier = $RELEASE_DIR"

mkdir -p "$RELEASE_DIR"

echo "Clone du dépôt..."
git clone "$REPO_URL" "$RELEASE_DIR"


cp "$ENV_SOURCE" "$RELEASE_DIR/.env"

cd "$RELEASE_DIR"

$COMPOSER_BIN update

$NPM_BIN install
$NPM_BIN run build
$NPM_BIN audit fix

php artisan key:generate

ln -sfn "$RELEASE_DIR" /var/www/releases/current

chown -R administrateur:administrateur /var/www/releases/current/

chmod -R 775 /var/www/releases/current/
