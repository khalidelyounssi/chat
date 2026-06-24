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

## Deploiement

Le deploiement Docker complet se trouve dans [DEPLOYMENT.md](DEPLOYMENT.md).
# chat
