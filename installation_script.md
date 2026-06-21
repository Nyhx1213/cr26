# Guide d'installation d'une application Laravel

## 1. Connexion en root
```bash
su - root
```

## 2. Installation des dépendances système
```bash
apt install curl -y apache2 libapache2-mod-php git php sudo
apt install -y php php-cli php-common php-curl php-dom php-fileinfo php-mbstring php-xml php-pdo php-mysql php-zip
```

## 3. Activation du module rewrite Apache
```bash
a2enmod rewrite
systemctl restart apache2
```

## 4. Installation de Composer
```bash
curl -sS https://getcomposer.org/installer -o composer-setup.php
sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer
```

## 5. Création de l'utilisateur administrateur
```bash
adduser administrateur
usermod -aG administrateur www-data
chown -R administrateur:administrateur /var/www
chmod -R 775 /var/www
```

## 6. Installation de Node.js (via NVM)
> Quitter root avant cette étape
```bash
exit
curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.40.3/install.sh | bash
\. "$HOME/.nvm/nvm.sh"
```
Rouvrir le terminal, puis :
```bash
nvm install 24
node -v
npm -v
```

## 7. Configuration de l'environnement Laravel
- Créer un fichier `.env` dans `/home/administrateur/`
- Copier le script `deploy.sh` dans `/home/administrateur/`
- Exécuter `deploy.sh` en tant qu'**administrateur**

## 8. Configuration Apache

Créer un fichier de configuration (ex: `current-laravel.conf`) :
```apache
<VirtualHost *:80>
    DocumentRoot /var/www/current
    ServerName nom_de_votre_projet
    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
    <Directory /var/www/current>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

Puis activer la configuration :
```bash
a2dissite 000-default.conf
a2ensite current-laravel.conf
```