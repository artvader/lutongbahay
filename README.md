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
