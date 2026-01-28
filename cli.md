cd /c/wamp64/www/sites && \
mkdir -p w3.gaelgerard.com/{current/web/wp-content/{themes/plugins,mu-plugins},releases,shared/{uploads,logs},repo} && \
touch w3.gaelgerard.com/shared/.env && \
echo "Architecture créée avec succès pour w3.gg"

cd /c/wamp64/www/sites/w3.gaelgerard.com/current/web

wp core download --locale=fr_FR

réation de la base + utilisateur MySQL
Connexion MySQL (depuis Git Bash)

mysql -u root -p

CREATE DATABASE gaelgerard_w3ggcom
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

CREATE USER 'gaelgerard_w3'@'localhost'
  IDENTIFIED BY 'GCWFw3S?}m5-';

GRANT ALL PRIVILEGES
  ON gaelgerard_w3ggcom.*
  TO 'gaelgerard_w3'@'localhost';

FLUSH PRIVILEGES;

EXIT;

wp config create \
  --dbname=gaelgerard_w3ggcom \
  --dbuser=gaelgerard_w3 \
  --dbpass='GCWFw3S?}m5-' \
  --dbhost=localhost \
  --dbcharset=utf8mb4 \
  --locale=fr_FR

wp core install \
  --url=http://w3.gg \
  --title="Blog Gaël Gérard – Web & WordPress" \
  --admin_user=admin \
  --admin_password=ChangeMoi123! \
  --admin_email=contact@gaelgerard.com

wp plugin delete hello
wp theme delete twentytwentythree twentytwentytwo
wp option update blogdescription "Développement WordPress, performance et bonnes pratiques web"

Étape suivante : Sage » 🚀

cd wp-content/themes

composer create-project roots/sage w3-sage

cd w3-sage

npm install

Entête style.css

/*
Theme Name: W3 – Gaël Gérard
Theme URI: https://gaelgerard.com
Author: Gaël Gérard
Author URI: https://gaelgerard.com
Description: Blog technique WordPress orienté bonnes pratiques et performance
Version: 1.0.0
Text Domain: w3
*/

b) URL du site (important pour Vite)

Dans .env à la racine du thème :

WP_HOME=http://w3.gg
WP_SITEURL=http://w3.gg
APP_NAME="W3 Sage"
APP_ENV=local
APP_URL=http://w3.gg

npm run build
wp theme activate w3-sage

wp acorn optimize:clear
npm run dev 

wp-content/themes/w3-sage/resources/styles/
├── tokens/           ← variables (couleurs, typo, spacing)
│   └── _colors.scss
│   └── _typography.scss
│   └── _spacing.scss
├── base/             ← reset, body, liens, headings
│   └── _base.scss
├── layout/           ← header, footer, main layout
│   └── _layout.scss
├── components/       ← boutons, cards, etc.
│   └── _buttons.scss
│   └── _cards.scss
├── utilities/        ← helpers flex, margin, text align
│   └── _helpers.scss
└── app.scss          ← fichier principal qui importe tout

Création des fichiers pour le design system
mkdir -p wp-content/themes/w3-sage/resources/styles/{tokens,base,layout,components,utilities} && touch wp-content/themes/w3-sage/resources/styles/{tokens/{_colors.scss,_typography.scss,_spacing.scss},base/_base.scss,layout/_layout.scss,components/{_buttons.scss,_cards.scss},utilities/_helpers.scss,app.scss}

#!/usr/bin/env bash

# ============================================================
# Setup dépôt WordPress clean + Sage (CI/CD ready)
# Projet : w3.gg blog
# Auteur : Gaël Gérard
# ============================================================

set -e

# 1. Définir le chemin projet
PROJECT_DIR="/c/wamp64/www/sites/w3.gaelgerard.com"

echo "📂 Création du projet dans : $PROJECT_DIR"

# 2. Créer la structure principale
mkdir -p "$PROJECT_DIR"/{web/app/themes,config/environments}

# 3. Créer fichiers de base
touch "$PROJECT_DIR"/composer.json
touch "$PROJECT_DIR"/package.json
touch "$PROJECT_DIR"/vite.config.js

# 4. Ajouter un thème placeholder (sera remplacé par Sage)
mkdir -p "$PROJECT_DIR/web/app/themes/w3-sage"

# 5. Créer .env.example
cat > "$PROJECT_DIR/.env.example" <<'EOF'
APP_ENV=development
APP_URL=http://w3.gg

DB_NAME=gaelgerard_w3ggcom
DB_USER=gaelgerard_w3
DB_PASSWORD=********
DB_HOST=localhost
EOF

# 6. Créer .gitignore pro Roots/Sage
cat > "$PROJECT_DIR/.gitignore" <<'EOF'
# Dependencies
node_modules/
vendor/

# Build artifacts
public/build/
web/app/themes/*/public/build/

# WordPress core
web/wp/

# Uploads
web/app/uploads/

# Environment secrets
.env

# OS / IDE
.DS_Store
Thumbs.db
.vscode/
.idea/
EOF

# 7. Créer README.md vitrine
cat > "$PROJECT_DIR/README.md" <<'EOF'
# Blog w3.gg — WordPress + Sage

Projet de refonte de mon blog en suivant les bonnes pratiques modernes :

- WordPress (Bedrock-like)
- Roots Sage + Vite
- SCSS structuré
- CI/CD ready

---

## Installation

```bash
composer install
npm install
