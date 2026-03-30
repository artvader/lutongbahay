# Lutong Pinoy - Product Vision Memo

**Date:** March 30, 2026
**Author:** CEO
**Version:** 1.0 (v1 Launch)

---

## 1. Mission Statement

Make authentic Filipino home cooking accessible to everyone by providing a beautifully designed, easy-to-use recipe platform that preserves traditional flavors while guiding cooks of all skill levels through each dish step by step.

## 2. Target Audience

**Primary:** Filipino diaspora (ages 20-45) who want to cook dishes from home but lack family recipes or hands-on guidance. They are comfortable with mobile devices, search for recipes online regularly, and value authenticity.

**Secondary:**
- Food-curious home cooks of any background exploring Southeast Asian cuisine
- Filipino home cooks who want a single, reliable, well-organized source for classic recipes
- Content creators and food bloggers looking for reference material on traditional Filipino dishes

## 3. Key Value Propositions

- **Curated authenticity.** 100 hand-selected Filipino recipes reviewed for accuracy -- not user-generated noise, but trusted content managed through a dedicated CMS.
- **Step-by-step clarity.** Every recipe breaks down into numbered steps with prep time, cook time, and difficulty level so users know exactly what they are getting into before they start.
- **Mobile-first experience.** Designed for the kitchen counter -- large type, minimal scrolling mid-step, and touch-friendly controls built with Vue 3 and Tailwind CSS.
- **Find what you crave, fast.** Full-text search and category filters (by region, course, ingredient, difficulty) let users go from craving to cooking in seconds.
- **Save, rate, and print.** Favorite the dishes you love, rate them to surface the best, and export any recipe as a clean PDF for offline or printed use.

## 4. v1 Success Metrics / KPIs

| Metric | Target (first 90 days) |
|---|---|
| Monthly active users (MAU) | 2,000 |
| Recipes viewed per session | >= 2.5 |
| Favorites saved per active user | >= 5 |
| Recipes rated (total) | >= 500 ratings |
| PDF downloads | >= 300 |
| Average page load (mobile, 3G) | < 3 seconds |
| Bounce rate (homepage) | < 45% |

## 5. v1 Scope

### IN scope

- 100 pre-loaded Filipino recipes with images, ingredients, step-by-step instructions, prep/cook time, difficulty level, and category tags
- Search (full-text across recipe titles, ingredients, and descriptions)
- Category filters (course type, region, difficulty, main ingredient)
- User favorites (local/session-based for v1, no mandatory account creation)
- Star ratings on recipes
- PDF export / print-friendly view for any recipe
- Mobile-first responsive design (Vue 3 + Tailwind CSS frontend)
- English language only
- SQLite database, deployed to shared hosting
- Basic SEO (meta tags, semantic HTML, Open Graph)

### OUT of scope (deferred to v2+)
- CMS admin panel (Laravel-based) for managing recipe content (CRUD, image upload, category management)
- User comments or reviews (no moderation tooling yet)
- User accounts / authentication (favorites will be device-local in v1)
- Multi-language support (Filipino/Tagalog planned for v2)
- Meal planning or grocery list generation
- Video content or embedded cooking videos
- Social sharing deep integrations
- Nutritional information / calorie counts
- Native mobile apps (iOS/Android)
- User-submitted recipes or community contributions
- Push notifications

---

*This memo establishes the north star for v1. All design, engineering, and content decisions should trace back to these priorities. When in doubt, optimize for the primary audience cooking on their phone in the kitchen.*
