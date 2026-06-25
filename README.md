# Chatterie Site

Application Laravel pour la gestion et la presentation de la chatterie.

## Demarrage local

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan storage:link
npm install
npm run build
php artisan serve
```

## Acces admin local

- Email: `admin@soleils-orient.test`
- Mot de passe: `admin2000`
- Variable admin: `ADMIN_EMAIL=admin@soleils-orient.test`

## HTTPS production

- HTTP: `APP_URL=http://votre-domaine`
- SSL automatique nginx si `SSL_DOMAIN` pointe vers un certificat Let's Encrypt disponible sur le serveur
- Webroot ACME: `docker/certbot/www`

## Deploiement

Le deploiement Docker complet se trouve dans [DEPLOYMENT.md](DEPLOYMENT.md).
# chat
