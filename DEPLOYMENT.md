# Deploy ke Production (kwarranbekasitimur.id)

## Persyaratan Hosting

- PHP >= 8.0
- MySQL >= 5.7
- Composer
- SSH Access (recommended)
- OpenSSL PHP extension
- PDO PHP extension
- Mbstring PHP extension

## Steps Deployment

### 1. Upload Project ke Server

Gunakan FTP/SCP atau git clone:

```bash
git clone <repository-url> /home/username/public_html/kwarran
# atau
scp -r kwarran/ username@server:/home/username/public_html/
```

### 2. SSH ke Server

```bash
ssh username@server
cd /home/username/public_html/kwarran
```

### 3. Install Dependencies

```bash
composer install --optimize-autoloader --no-dev
```

### 4. Setup Environment File

```bash
cp .env.example .env
```

Edit `.env` dengan:
```
APP_ENV=production
APP_DEBUG=false
APP_URL=https://kwarranbekasitimur.id

DB_HOST=localhost
DB_DATABASE=kwarran_bekasi
DB_USERNAME=db_user
DB_PASSWORD=secure_password
```

### 5. Generate Application Key

```bash
php artisan key:generate
```

### 6. Create Database & Run Migrations

```bash
mysql -u db_user -p kwarran_bekasi < /path/to/backup.sql
# atau
php artisan migrate --force
php artisan db:seed --force
```

### 7. Set Permissions

```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
chmod 644 .env
```

### 8. Configure Web Server

#### Nginx Configuration

```nginx
server {
    listen 80;
    server_name kwarranbekasitimur.id;
    
    root /home/username/public_html/kwarran/public;
    index index.php;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.0-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
    
    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

#### Apache Configuration (.htaccess)

Sudah tersedia di `/public/.htaccess`

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    
    RewriteCond %{REQUEST_FILENAME} -d [OR]
    RewriteCond %{REQUEST_FILENAME} -f
    RewriteRule ^ ^ [L]
    
    RewriteRule ^ index.php [L]
</IfModule>
```

### 9. Enable HTTPS with SSL

```bash
# Menggunakan Let's Encrypt
certbot certonly --standalone -d kwarranbekasitimur.id
```

### 10. Optimize Production

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
```

### 11. Setup Database Backup (Cron Job)

Add to crontab:
```bash
0 2 * * * mysqldump -u db_user -ppassword kwarran_bekasi > /backup/kwarran_$(date +\%Y\%m\%d).sql
```

### 12. Monitor Application

Setup error logging and monitoring:
```bash
# Check logs
tail -f storage/logs/laravel.log

# Setup log rotation
sudo apt-get install logrotate
```

## Configuration untuk Domain

### DNS Settings

```
Type    Name                 Value
A       kwarranbekasitimur   YOUR_SERVER_IP
CNAME   www                  kwarranbekasitimur.id
```

### Update APP_URL

In `.env`:
```
APP_URL=https://kwarranbekasitimur.id
```

## Security Checklist

- [ ] Update PHP ke versi terbaru
- [ ] Change default database credentials
- [ ] Set proper file permissions (storage, bootstrap)
- [ ] Enable HTTPS/SSL
- [ ] Setup firewall
- [ ] Disable directory listing
- [ ] Remove .env dari public access
- [ ] Setup automated backups
- [ ] Enable error logging
- [ ] Setup monitoring/alerting

## Backup & Recovery

### Database Backup

```bash
mysqldump -u db_user -p kwarran_bekasi > backup_$(date +%Y%m%d_%H%M%S).sql
```

### Full Backup

```bash
tar -czf kwarran_backup_$(date +%Y%m%d).tar.gz /home/username/public_html/kwarran/
```

### Restore

```bash
mysql -u db_user -p kwarran_bekasi < backup.sql
tar -xzf kwarran_backup.tar.gz -C /
```

## Monitoring & Maintenance

### Check PHP Version
```bash
php -v
```

### Check Disk Space
```bash
df -h
```

### Check Memory Usage
```bash
free -h
```

### Laravel Health Check
```bash
php artisan tinker
>>> DB::connection()->getPdo();
>>> exit
```

## Troubleshooting

### 500 Error
```bash
php artisan config:clear
php artisan cache:clear
```

### Database Connection Error
```bash
# Check database
mysql -u username -p -e "SHOW DATABASES;"

# Check Laravel config
php artisan tinker
>>> DB::connection()->getPdo();
```

### Permission Denied
```bash
chmod -R 755 /home/username/public_html/kwarran
chmod -R 755 storage bootstrap
```

## Performance Optimization

### Enable Caching

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Database Indexing
```sql
ALTER TABLE posts ADD INDEX idx_category_published (category_id, is_published);
ALTER TABLE posts ADD INDEX idx_published_date (published_at);
```

### Setup CDN
Use CloudFlare or similar for:
- Static asset caching
- DDoS protection
- Global distribution

## Monitoring Services

Recommended:
- **Uptime Monitor**: UptimeRobot, Pingdom
- **Error Tracking**: Sentry, Rollbar
- **Performance**: New Relic, Datadog
- **Analytics**: Google Analytics, Matomo

## Support & Resources

- Laravel Production: https://laravel.com/docs/deployment
- Nginx Configuration: https://docs.nginx.com/
- SSL Setup: https://certbot.eff.org/
- MySQL Optimization: https://dev.mysql.com/doc/

---

**Last Updated:** Februari 2026
