Lutong Bahay shared hosting package

Contents
- app/: upload this whole folder outside public_html if your host allows it.
- public_html/: upload the contents of this folder into your web root.

Recommended shared hosting layout
- /home/USERNAME/app
- /home/USERNAME/public_html

Steps
1. FTP upload deploy/shared-hosting/app to a non-public folder on the server.
2. FTP upload deploy/shared-hosting/public_html/* into public_html.
3. On the server, copy app/.env.example to app/.env and fill in:
   - APP_KEY
   - APP_URL
   - DB_DATABASE
   - CORS_ALLOWED_ORIGIN
4. Make sure these folders are writable by PHP:
   - app/storage
   - app/bootstrap/cache
5. If your host supports terminal access, run:
   - php artisan key:generate
   - php artisan migrate --force
   - php artisan config:cache
   - php artisan route:cache

Notes
- This package already contains the built Vue frontend in public_html/frontend.
- public_html/index.php is pre-adjusted to load Laravel from ../app.
- If your host forces a different folder layout, update public_html/index.php paths to match.
- If the host does not provide SSH, generate APP_KEY locally and paste it into app/.env before uploading.

Files in public_html
- .htaccess, css, favicon.ico, frontend, images, index.php, js, mix-manifest.json, robots.txt
