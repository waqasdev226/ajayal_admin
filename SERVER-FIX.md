# Fix "Not Found" / Server stopped after git pull

## Why it broke

The last deploy **removed `.env` from the repo** (so secrets are not in Git). If you ran `git pull` on the server, Git **deleted the server's `.env` file**. Without `.env`, Laravel cannot start, so you get "Not Found" or a blank/error page.

## Fix on the server (SSH into admin.ajayal.com)

### 1. Recreate `.env`

```bash
cd /path/to/ajayal_admin   # your project root on the server

# If you have a backup of .env, restore it:
# cp /path/to/backup/.env .env

# Otherwise, copy from the template and edit:
cp .env.example .env
nano .env   # or vim .env
```

Set at least:

- `APP_KEY=` → run `php artisan key:generate` to fill it, or paste your previous key
- `APP_URL=https://admin.ajayal.com`
- `DB_CONNECTION`, `DB_HOST`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` (your live MySQL)

Save and exit.

### 2. Generate APP_KEY if new .env

```bash
php artisan key:generate
```

### 3. Clear caches

```bash
php artisan config:clear
php artisan cache:clear
```

### 4. Confirm document root

Your web server (Nginx/Apache) must use the **`public`** folder as document root, not the project root.

- **Nginx:** `root /path/to/ajayal_admin/public;`
- **Apache:** `DocumentRoot /path/to/ajayal_admin/public`

### 5. Restart PHP / web server (if needed)

```bash
# Nginx + PHP-FPM example:
sudo systemctl restart php8.2-fpm   # use your PHP version
sudo systemctl reload nginx
```

After this, https://admin.ajayal.com/ should load again. If you still see "Not Found", check the server error log (e.g. `storage/logs/laravel.log` or Nginx error log).
