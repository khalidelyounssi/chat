# Maintenance Checklist

## Production deploy

```bash
cd /var/www/chat
git pull origin main
docker compose up -d --build
docker compose exec app php artisan migrate --force
docker compose exec app php artisan optimize:clear
```

## Quick health checks

```bash
docker compose ps
docker compose logs --tail=120 app
docker compose logs --tail=120 nginx
curl -I https://chatteriedessoleilsdorient.com
```

## Backups

Create a backup manually:

```bash
cd /var/www/chat
chmod +x scripts/backup-site.sh
./scripts/backup-site.sh
```

Recommended daily cron at 03:30:

```bash
30 3 * * * cd /var/www/chat && ./scripts/backup-site.sh >> /var/log/chatterie-backup.log 2>&1
```

Each backup contains:

- `database.sqlite`
- `storage.tar.gz`
- `.env.docker`
- `letsencrypt.tar.gz` when available

## SSL

Check certificate renewal:

```bash
certbot renew --dry-run
```

The nginx reload hook is stored in:

```bash
/etc/letsencrypt/renewal-hooks/deploy/reload-chatterie-nginx.sh
```

## SEO routine

Every time you add a new cat:

- Fill the description with precise, human text.
- Upload a clean main image.
- Keep the status accurate.
- Verify the page appears in `https://chatteriedessoleilsdorient.com/sitemap.xml`.

Monthly SEO check:

- Search `site:chatteriedessoleilsdorient.com` on Google.
- Verify canonical URLs use the non-`www` domain.
- Confirm `robots.txt` and `sitemap.xml` load correctly.
- Review page titles and descriptions for important pages.

## Restore notes

To restore the database quickly:

```bash
docker compose exec -T app sh -lc 'cat > /var/www/html/storage/database/database.sqlite' < /path/to/database.sqlite
```

To restore storage files:

```bash
docker compose exec -T app sh -lc 'cd /var/www/html && tar -xzf -' < /path/to/storage.tar.gz
```
