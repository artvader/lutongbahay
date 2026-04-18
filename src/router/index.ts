import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '@/views/HomeView.vue'
import BrowseView from '@/views/BrowseView.vue'
import RecipeView from '@/views/RecipeView.vue'
import SavedView from '@/views/SavedView.vue'
import MoreView from '@/views/MoreView.vue'

const normalizeAppBase = (value?: string) => {
  if (!value || value === '/') return '/'

  const withLeadingSlash = value.startsWith('/') ? value : `/${value}`
  return withLeadingSlash.endsWith('/') ? withLeadingSlash : `${withLeadingSlash}/`
}

export const router = createRouter({
  history: createWebHistory(normalizeAppBase(import.meta.env.VITE_APP_BASE_PATH)),
  routes: [
    { path: '/', name: 'home', component: HomeView },
    { path: '/browse', name: 'browse', component: BrowseView },
    { path: '/recipe/:slug', name: 'recipe', component: RecipeView },
    { path: '/saved', name: 'saved', component: SavedView },
    { path: '/more', name: 'more', component: MoreView },
  ],
  scrollBehavior(to, _from, saved) {
    if (saved) return saved
    if (to.hash) return { el: to.hash, behavior: 'smooth' }
    return { top: 0 }
  },
})
