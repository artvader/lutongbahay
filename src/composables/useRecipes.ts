import { computed, ref } from 'vue'
import type { Recipe } from '@/types/recipe'

const recipes = ref<Recipe[]>([])
const loading = ref(false)
const loaded = ref(false)
const error = ref<string | null>(null)

const API_BASE = import.meta.env.VITE_CMS_API_BASE_URL || '/api'

const fallbackFilterGroups = {
  course: ['Main', 'Soup', 'Noodles', 'Appetizer', 'Dessert'],
  region: ['National', 'Luzon', 'Visayas', 'Mindanao'],
  difficulty: ['Easy', 'Medium', 'Hard'],
  ingredient: ['Chicken', 'Pork', 'Beef', 'Seafood', 'Noodles', 'Mixed'],
}

const filterGroups = computed(() => {
  if (!recipes.value.length) return fallbackFilterGroups

  const unique = (values: string[]) => Array.from(new Set(values)).sort((a, b) => a.localeCompare(b))
  return {
    course: unique(recipes.value.map((r) => r.course)),
    region: unique(recipes.value.map((r) => r.region)),
    difficulty: unique(recipes.value.map((r) => r.difficulty)),
    ingredient: unique(recipes.value.map((r) => r.mainIngredient)),
  }
})

const normalizeRecipe = (recipe: any): Recipe => ({
  id: String(recipe.id),
  slug: recipe.slug,
  title: recipe.title,
  description: recipe.description ?? '',
  imageUrl: recipe.imageUrl ?? '',
  imageAlt: recipe.imageAlt ?? recipe.title ?? '',
  prepMins: Number(recipe.prepMins ?? 0),
  cookMins: Number(recipe.cookMins ?? 0),
  difficulty: recipe.difficulty,
  rating: Number(recipe.rating ?? 0),
  ratingCount: Number(recipe.ratingCount ?? 0),
  region: recipe.region ?? 'National',
  course: recipe.course ?? 'Main',
  mainIngredient: recipe.mainIngredient ?? 'Mixed',
  featured: Boolean(recipe.featured),
  ingredients: Array.isArray(recipe.ingredients) ? recipe.ingredients : [],
  steps: Array.isArray(recipe.steps) ? recipe.steps : [],
})

const ensureRecipesLoaded = async () => {
  if (loaded.value || loading.value) return

  loading.value = true
  error.value = null

  try {
    const response = await fetch(`${API_BASE}/recipes`)
    if (!response.ok) throw new Error(`Failed to load recipes (${response.status})`)
    const data = await response.json()
    recipes.value = Array.isArray(data) ? data.map(normalizeRecipe) : []
    loaded.value = true
  } catch (err: any) {
    error.value = err?.message ?? 'Failed to load recipes'
    recipes.value = []
  } finally {
    loading.value = false
  }
}

const getRecipeBySlug = (slug: string) => recipes.value.find((r) => r.slug === slug)

export const useRecipes = () => ({
  recipes,
  loading,
  loaded,
  error,
  filterGroups,
  ensureRecipesLoaded,
  getRecipeBySlug,
})
