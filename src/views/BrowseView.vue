<script setup lang="ts">
import { onMounted } from 'vue'
import { useRecipeBrowse } from '@/composables/useRecipeBrowse'
import SearchAndFilters from '@/components/SearchAndFilters.vue'
import RecipeCard from '@/components/RecipeCard.vue'

const {
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
} = useRecipeBrowse()

onMounted(() => {
  const el = document.getElementById('recipe-search')
  el?.focus()
})
</script>

<template>
  <div class="mx-auto max-w-6xl px-4 py-8 md:py-10">
    <header class="mb-8">
      <h1 class="font-heading text-h1 text-uling">Browse Recipes</h1>
      <p class="mt-2 max-w-2xl text-body text-kawayan">
        Find a dish by name, ingredient, or mood. Filters use live data from the CMS recipe database.
      </p>
    </header>

    <div class="md:flex md:items-start md:gap-8">
      <aside class="md:w-[320px] md:shrink-0 md:sticky md:top-24 max-md:mb-10">
        <SearchAndFilters
          v-model:query="query"
          :courses="courses"
          :regions="regions"
          :difficulties="difficulties"
          :ingredients="ingredients"
          :show-search="false"
          @toggle-course="toggleCourse"
          @toggle-region="toggleRegion"
          @toggle-difficulty="toggleDifficulty"
          @toggle-ingredient="toggleIngredient"
          @clear="clearFilters"
        />
      </aside>

      <section class="md:flex-1 w-full min-w-0" aria-labelledby="results-heading">
        <div class="mb-6 flex flex-wrap items-baseline justify-between gap-2">
          <h2 id="results-heading" class="font-heading text-h2 text-uling">
            Results
          </h2>
          <p class="text-small text-kawayan tabular-nums">
            {{ filteredRecipes.length }} recipes
          </p>
        </div>
        <div
          v-if="filteredRecipes.length === 0"
          class="rounded-card border border-dashed border-bayong bg-harina/50 px-6 py-12 text-center"
        >
          <p class="font-heading text-h3 text-uling">No matches</p>
          <p class="mt-2 text-small text-kawayan">
            Adjust your search or clear filters to see the full set.
          </p>
          <button
            type="button"
            class="mt-6 min-h-[48px] rounded-btn bg-terracotta px-6 font-body text-small font-semibold text-white hover:bg-terracotta-dark"
            @click="clearFilters"
          >
            Reset
          </button>
        </div>
        <ul v-else class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
          <li v-for="r in filteredRecipes" :key="r.id" class="h-full">
            <RecipeCard :recipe="r" />
          </li>
        </ul>
      </section>
    </div>
  </div>
</template>
