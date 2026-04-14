import { computed, ref, watch } from 'vue'
import { useRoute } from 'vue-router'
import { recipes } from '@/data/recipes'
import type { Difficulty } from '@/types/recipe'

export const useRecipeBrowse = () => {
  const route = useRoute()
  const query = ref((route.query.q as string) || '')
  
  watch(
    () => route.query.q,
    (newQ) => {
      if (newQ !== undefined) query.value = newQ as string
    }
  )
  const courses = ref<Set<string>>(new Set())
  const regions = ref<Set<string>>(new Set())
  const difficulties = ref<Set<Difficulty>>(new Set())
  const ingredients = ref<Set<string>>(new Set())

  const toggle = (set: Set<string>, value: string) => {
    const next = new Set(set)
    if (next.has(value)) next.delete(value)
    else next.add(value)
    return next
  }

  const toggleCourse = (v: string) => {
    courses.value = toggle(courses.value, v)
  }
  const toggleRegion = (v: string) => {
    regions.value = toggle(regions.value, v)
  }
  const toggleDifficulty = (v: Difficulty) => {
    const next = new Set(difficulties.value)
    if (next.has(v)) next.delete(v)
    else next.add(v)
    difficulties.value = next
  }
  const toggleIngredient = (v: string) => {
    ingredients.value = toggle(ingredients.value, v)
  }

  const filteredRecipes = computed(() => {
    const q = query.value.trim().toLowerCase()
    return recipes.filter((r) => {
      if (courses.value.size && !courses.value.has(r.course)) return false
      if (regions.value.size && !regions.value.has(r.region)) return false
      if (difficulties.value.size && !difficulties.value.has(r.difficulty)) return false
      if (ingredients.value.size && !ingredients.value.has(r.mainIngredient)) return false
      if (!q) return true
      const hay = [
        r.title,
        r.description,
        ...r.ingredients,
        r.region,
        r.course,
        r.mainIngredient,
      ]
        .join(' ')
        .toLowerCase()
      return hay.includes(q)
    })
  })

  const clearFilters = () => {
    courses.value = new Set()
    regions.value = new Set()
    difficulties.value = new Set()
    ingredients.value = new Set()
    query.value = ''
  }

  return {
    query,
    courses,
    regions,
    difficulties,
    ingredients,
    toggleCourse,
    toggleRegion,
    toggleDifficulty,
    toggleIngredient,
    filteredRecipes,
    clearFilters,
  }
}
