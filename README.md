Installation en local
Cloner le dépôt à travers d'un terminal et utiliser la commande

git clone https://github.com/Nyhx1213/cr26.git

Ce situer dans le dossier

cd cr26

Télécharger composer et utiliser ajouter les package vendor

sudo apt install composer, composer update

Installer npm dans le dépôt

npm install, npm run build , npm audit fix

Création d'un .env à partir de .env.exemple et configuration :
Base de données :
    DB_CONNECTION = type de base de données
    DB_HOST= addresse contenant le SGBD
    DB_PORT = port du SGBD
    DB_DATABASE = nom de la base
    DB_USERNAME = nom utilisateur du SGBD
    DB_PASSWORD =  mot de passe
    DB_TABLE_PREFIX = mcd_
Config serveur envoi de mail :
    MAIL_MAILER= protocol
    MAIL_HOST=adresse host
    MAIL_PORT= port 
    MAIL_USERNAME= nom utilisateur
    MAIL_PASSWORD= mot de passe
    MAIL_FROM_ADDRESS= addresse@mail
    MAIL_FROM_NAME="${APP_NAME}"
Génerer des clés

php artisan key:generate

Lancer l'application

php artisan serve

Dans le cas ou une erreur arrive veuillez suivre les étapes suivantes pour debugger

sudo nano storage/framework/views/26aeb795f740ec621e2ffb711b74b8c3.php

Vers la fin du document enlever le 1 prés de la fonction handler()

Installation sur un serveur web
Télécharger un serveur web

sudo apt install apache2

Ce situer dans la partie public du serveur

cd /var/www/

Cloner le dépôt

git clone https://github.com/Nyhx1213/cr26.git

Donnez les droits

sudo chown -R www-data:www-data /var/www/cr26 sudo chmod 755 /var/www/cr26

Ce situer dans le dossier cr26

cd /var/www/cr26

Ajouter les packets avec npm et composer

sudo apt install composer
composer update
npm install
npm run build
npm audit fix

Création d'un .env à partir de .env.exemple et configuration :
Base de données :
  - DB_CONNECTION = type de base de données
  - DB_HOST= addresse contenant le SGBD
  - DB_PORT = port du SGBD
  - DB_DATABASE = nom de la base
  - DB_USERNAME = nom utilisateur du SGBD
  - DB_PASSWORD =  mot de passe
  - DB_TABLE_PREFIX = mcd_
Config serveur envoi de mail :
- MAIL_MAILER= protocol
- MAIL_HOST=adresse host
- MAIL_PORT= port 
- MAIL_USERNAME= nom utilisateur
- MAIL_PASSWORD= mot de passe
- MAIL_FROM_ADDRESS= addresse@mail
- MAIL_FROM_NAME="${APP_NAME}"
Génerer des clés

php artisan key:generate

Création d'une configuration dans le serveur web

cd /etc/apache/sites-available
nano monsite.conf

Exemple de conf

<VirtualHost *:80>
    DocumentRoot /var/www/nom_de_votre_projet/public
    ServerName nom_de_votre_projet
    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
    <Directory /var/www/nom_de_votre_projet/public>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
Activer la configuration

a2dissite 000-default.conf
a2ensite monsite.conf

Activer le mod rewrite de apache

a2enmod rewrite

Dans le cas ou une erreur arrive veuillez suivre les étapes suivantes pour debugger

sudo nano storage/framework/views/26aeb795f740ec621e2ffb711b74b8c3.php

Vers la fin du document enlever le 1 prés de la fonction handler()
