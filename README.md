# Lutong Bahay

Unified frontend + CMS app: Filipino home-cooking recipes (Vue 3, Vite, Laravel CMS). See `docs/` for product vision and brand.

## Develop

```bash
npm install
npm run dev
```

`npm run dev` now starts both:
- Vue frontend on `http://127.0.0.1:5173`
- Laravel CMS/API on `http://127.0.0.1:8000`

## Build

```bash
npm run build
npm run preview
```

`npm run build` outputs the frontend bundle into `cms-project/public/frontend` for single-app deployment with Laravel.

## Shared Hosting Export

```bash
npm run build:shared-hosting
```

This creates `deploy/shared-hosting/` with:
- `app/` for the Laravel application files
- `public_html/` for the shared hosting web root

Upload `app/` outside the public web root when possible, then upload the contents of `public_html/` to your host via FTP. See `deploy/shared-hosting/README.txt` after building for the exact folder layout and setup steps.

Important: `VITE_APP_BASE_PATH` is intentionally chosen at build time.

That means you should build once for the exact URL path where the app will live:
- If the app will live at the domain root, build for `/`
- If the app will live in a subdirectory, build for that subdirectory path

Use one of these exact options before you upload to hosting.

### Option 1: Deploy At Domain Root

Use this when the final site URL will look like:
- `https://example.com/`
- `https://www.example.com/`

Build with:

```bash
$env:VITE_APP_BASE_PATH='/'
npm run build:shared-hosting
```

### Option 2: Deploy In A Subdirectory

Use this when the final site URL will look like:
- `https://example.com/lutongbahay/`
- `https://example.com/projects/lutongbahay/`

Build with the exact final path:

```bash
$env:VITE_APP_BASE_PATH='/lutongbahay/'
npm run build:shared-hosting
```

Replace `/lutongbahay/` with your real hosting subdirectory. Keep the leading and trailing slash.

Examples:

```bash
$env:VITE_APP_BASE_PATH='/recipes/'
npm run build:shared-hosting
```

```bash
$env:VITE_APP_BASE_PATH='/projects/lutongbahay/'
npm run build:shared-hosting
```

If you build with the wrong path, the app may open but CSS, JavaScript, images, routing, or API requests can fail after upload.

The frontend API base will follow that same subfolder automatically unless you explicitly override it with `VITE_CMS_API_BASE_URL`.

If you want the exporter to recreate `deploy/shared-hosting/app/.env` for a localhost test build, opt in explicitly:

```bash
$env:VITE_APP_BASE_PATH='/lutongbahay/deploy/shared-hosting/public_html/'
$env:SHARED_HOSTING_GENERATE_LOCAL_ENV='1'
npm run build:shared-hosting
```

That local test `.env` will default to `http://localhost...` for `APP_URL` and reuse `cms-project/.env`'s `APP_KEY` when available. You can override the generated values with `SHARED_HOSTING_LOCAL_APP_URL`, `SHARED_HOSTING_LOCAL_CORS_ORIGIN`, or `SHARED_HOSTING_LOCAL_APP_KEY` if needed.

### Hosting Upload Checklist

1. Build using the correct `VITE_APP_BASE_PATH` for the final hosting URL.
2. Upload `deploy/shared-hosting/app` outside `public_html` if your host allows it.
3. Upload the contents of `deploy/shared-hosting/public_html` into the site web root.
4. Copy `app/.env.example` to `app/.env` on the server.
5. Set `APP_URL` in `app/.env` to the real final site URL.
6. Set `APP_KEY`, `DB_DATABASE`, and `CORS_ALLOWED_ORIGIN` in `app/.env`.
7. Make sure `app/storage` and `app/bootstrap/cache` are writable by PHP.
8. If your host provides terminal access, run the Laravel cache commands listed in `deploy/shared-hosting/README.txt`.

This deployment section is intentionally kept at the very bottom of the README for quick production handoff.
