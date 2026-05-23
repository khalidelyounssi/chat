# Chatterie Site

Application Laravel pour la gestion et la presentation de la chatterie.

## Demarrage local

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm install
npm run build
php artisan serve
```

## Deploiement

Le deploiement Docker complet se trouve dans [DEPLOYMENT.md](DEPLOYMENT.md).
# chat
