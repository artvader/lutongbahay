# Brand Identity & Design System

---

## 1. App Name

### **Lutong Bahay**

*Lutong Bahay* (lu-tong ba-hai) is a Filipino phrase meaning "home-cooked" — it evokes the warmth, love, and authenticity of food made at home. It is universally understood across Filipino dialects, carries deep cultural resonance, and immediately signals that this app is rooted in Filipino home cooking tradition. The name is easy to say, memorable, and feels like an invitation to the kitchen.

---

## 2. Tagline

> **"Luto na tayo."** — *Let's cook.*

Simple, warm, communal. The use of "tayo" (we/us, inclusive) reinforces that cooking is a shared experience. It works as both a call to action and a cultural greeting — the same way a Filipino family member might announce that the food is ready or that it's time to start cooking together.

---

## 3. Color Palette

Inspired by the Filipino landscape — golden sunsets over rice terraces, the warm terracotta of clay pots (*palayok*), the deep greens of banana leaves, the rich brown of woven *bayong* baskets, and the vibrant accent of calamansi citrus.

| Role | Name | Hex | Usage |
|------|------|-----|-------|
| **Primary** | Palayok Terracotta | `#C2582A` | Primary buttons, headers, active states, key CTAs |
| **Primary Dark** | Clay Earth | `#8B3A1D` | Hover states, emphasis text, active nav |
| **Secondary** | Dahon Green | `#2D6A4F` | Secondary buttons, success states, category tags |
| **Secondary Light** | Banana Leaf | `#74A67E` | Badges, subtle highlights, secondary tags |
| **Accent** | Calamansi Gold | `#E8A838` | Stars/ratings, alerts, featured badges, highlights |
| **Accent Warm** | Sunset Mango | `#F0734A` | Gradient accents, promotional banners |
| **Background** | Bigas White | `#FAF7F2` | Page background — warm off-white like rice |
| **Surface** | Harina Cream | `#F2EDE4` | Card backgrounds, input fields, elevated surfaces |
| **Text Primary** | Uling Dark | `#2B2118` | Headings, body text — warm near-black |
| **Text Secondary** | Kawayan Gray | `#6B5E52` | Captions, metadata, placeholder text |
| **Border** | Bayong Tan | `#D9CDBF` | Dividers, card borders, subtle separators |

### Color Relationships
- **High contrast**: Palayok Terracotta on Bigas White passes WCAG AA for large text
- **Text accessibility**: Uling Dark on Bigas White exceeds WCAG AAA (contrast ratio > 12:1)
- **Warm palette unity**: Every color shares a warm undertone, creating visual cohesion

---

## 4. Typography

### Heading Font: **DM Serif Display**
- Elegant serif with warm, rounded terminals
- Feels both modern and traditional — like a hand-painted Filipino restaurant sign rendered for the web
- Strong presence at large sizes for recipe titles and hero text
- Weight used: 400 (Regular)

### Body Font: **Inter**
- Clean, highly legible sans-serif optimized for screens
- Excellent at small sizes — critical for recipe steps, ingredient lists, and nutritional info
- Wide language support including Filipino/Tagalog diacritics
- Weights used: 400 (Regular), 500 (Medium), 600 (SemiBold), 700 (Bold)

### Type Scale (rem)
```
Hero:        2.5rem  / DM Serif Display
H1:          2rem    / DM Serif Display
H2:          1.5rem  / DM Serif Display
H3:          1.25rem / Inter SemiBold
Body:        1rem    / Inter Regular
Body Small:  0.875rem / Inter Regular
Caption:     0.75rem / Inter Medium (uppercase tracking for labels)
```

---

## 5. Design Tone

**Warm. Inviting. Clean. Proudly Filipino.**

The UI should feel like walking into a well-kept Filipino kitchen — everything has its place, the table is set, and there's always room for one more. It is:

- **Warm but not cluttered** — generous whitespace, earth-tone palette, soft shadows
- **Modern but not sterile** — rounded corners, warm colors, and organic photography prevent the UI from feeling cold or generic
- **Cultural but not costume** — Filipino identity is expressed through language (Tagalog UI labels where natural), food photography, and color choices — not through stereotypical clip art or forced folklore aesthetics
- **Confident but approachable** — bold serif headings and strong primary color convey authority on Filipino cuisine; the soft background and friendly copy keep it welcoming to beginners
- **Mobile-first** — thumb-friendly targets, bottom navigation, large touch areas, card-based layouts that stack naturally

---

## 6. Icon / Logo Concept

### Logo: Wordmark + Symbol

**Symbol:** A stylized *palayok* (traditional clay pot) with a gentle steam curl rising from it, forming a subtle heart shape. The pot silhouette is minimal — just 3-4 curved lines — modern enough to work as a favicon or app icon at 16px.

**Wordmark:** "Lutong Bahay" set in DM Serif Display, with "Lutong" in Palayok Terracotta (`#C2582A`) and "Bahay" in Uling Dark (`#2B2118`). The two-tone treatment creates visual rhythm and emphasizes "Lutong" (cooking) as the action word.

**Lockup Variants:**
1. **Horizontal** — symbol left, wordmark right (navbar, desktop header)
2. **Stacked** — symbol above, wordmark below (app icon, splash screen)
3. **Symbol only** — palayok icon (favicon, mobile tab bar)

**Favicon:** The palayok symbol in Palayok Terracotta on transparent background, with a single Calamansi Gold steam curl for warmth.

---

## 7. UI Component Style

### Cards (Recipe Cards)
- **Background:** Harina Cream (`#F2EDE4`)
- **Border radius:** `12px` (rounded, friendly)
- **Shadow:** `0 2px 8px rgba(43, 33, 24, 0.06)` — subtle warm shadow
- **Hover:** Slight lift — `translateY(-2px)` with shadow increase to `0 6px 16px rgba(43, 33, 24, 0.10)`
- **Image:** Top portion with `border-radius: 12px 12px 0 0`, lazy-loaded, 16:10 aspect ratio
- **Content padding:** `16px`
- **Title:** DM Serif Display, 1.125rem, Uling Dark
- **Meta row:** Inter 0.8rem, Kawayan Gray — cook time, difficulty, rating stars in Calamansi Gold

### Buttons
- **Primary:** Palayok Terracotta background, white text, `border-radius: 8px`, `padding: 12px 24px`, font Inter SemiBold 0.9rem. Hover: Clay Earth background. Active: scale 0.98.
- **Secondary:** Transparent background, Palayok Terracotta border (1.5px), Palayok Terracotta text. Hover: Palayok Terracotta background with white text (fill transition).
- **Ghost:** No border, Kawayan Gray text, hover shows Harina Cream background.
- **All buttons:** `transition: all 150ms ease`, no text-transform, minimum touch target 44x44px.

### Navigation
- **Mobile (primary):** Fixed bottom tab bar, 5 tabs max. Background: white with `border-top: 1px solid` Bayong Tan. Active tab: Palayok Terracotta icon + label. Inactive: Kawayan Gray icon, no label. Icons: 24px outlined style, filled when active.
- **Desktop:** Top horizontal bar, sticky. Logo left, search center, profile/actions right. Background: Bigas White with bottom border Bayong Tan. Active link underlined with 2px Palayok Terracotta.
- **Transitions:** Page transitions use a gentle 200ms fade. Tab switches are instant.

### Inputs & Forms
- **Background:** White (`#FFFFFF`)
- **Border:** 1.5px Bayong Tan, `border-radius: 8px`
- **Focus:** Border transitions to Palayok Terracotta, subtle box-shadow `0 0 0 3px rgba(194, 88, 42, 0.12)`
- **Label:** Inter Medium 0.8rem, Kawayan Gray, positioned above input
- **Placeholder:** Kawayan Gray at 60% opacity

### Tags / Chips
- **Default:** Harina Cream background, Kawayan Gray text, `border-radius: 20px`, `padding: 4px 12px`
- **Category (active):** Dahon Green background, white text
- **Featured:** Calamansi Gold background, Uling Dark text

---

## 8. Tailwind Custom Config

```js
// tailwind.config.js
/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./index.html",
    "./src/**/*.{js,ts,jsx,tsx}",
  ],
  theme: {
    extend: {
      colors: {
        // Primary
        terracotta: {
          DEFAULT: '#C2582A',
          dark: '#8B3A1D',
          light: '#D4784E',
        },
        // Secondary
        dahon: {
          DEFAULT: '#2D6A4F',
          light: '#74A67E',
        },
        // Accent
        calamansi: {
          DEFAULT: '#E8A838',
          light: '#F2C56B',
        },
        mango: '#F0734A',
        // Neutrals
        bigas: '#FAF7F2',
        harina: '#F2EDE4',
        uling: '#2B2118',
        kawayan: '#6B5E52',
        bayong: '#D9CDBF',
      },
      fontFamily: {
        heading: ['"DM Serif Display"', 'Georgia', 'serif'],
        body: ['Inter', 'system-ui', 'sans-serif'],
      },
      fontSize: {
        'hero': ['2.5rem', { lineHeight: '1.2', letterSpacing: '-0.02em' }],
        'h1': ['2rem', { lineHeight: '1.25', letterSpacing: '-0.01em' }],
        'h2': ['1.5rem', { lineHeight: '1.3' }],
        'h3': ['1.25rem', { lineHeight: '1.4' }],
        'body': ['1rem', { lineHeight: '1.6' }],
        'small': ['0.875rem', { lineHeight: '1.5' }],
        'caption': ['0.75rem', { lineHeight: '1.4', letterSpacing: '0.05em' }],
      },
      borderRadius: {
        'card': '12px',
        'btn': '8px',
        'chip': '20px',
      },
      boxShadow: {
        'card': '0 2px 8px rgba(43, 33, 24, 0.06)',
        'card-hover': '0 6px 16px rgba(43, 33, 24, 0.10)',
        'input-focus': '0 0 0 3px rgba(194, 88, 42, 0.12)',
      },
    },
  },
  plugins: [],
}
```

### Google Fonts Import

```html
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
```

---

## Quick Reference

| Token | Value |
|-------|-------|
| Primary action color | `bg-terracotta` / `text-terracotta` |
| Heading font | `font-heading` |
| Body font | `font-body` |
| Page background | `bg-bigas` |
| Card background | `bg-harina` |
| Card radius | `rounded-card` |
| Button radius | `rounded-btn` |
| Card shadow | `shadow-card` |
| Card hover shadow | `shadow-card-hover` |
| Input focus ring | `shadow-input-focus` |
| Primary text | `text-uling` |
| Secondary text | `text-kawayan` |
| Border/divider | `border-bayong` |
