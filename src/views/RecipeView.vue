<script setup lang="ts">
import { computed } from 'vue'
import { RouterLink, useRoute } from 'vue-router'
import { getRecipeBySlug } from '@/data/recipes'
import StarRating from '@/components/StarRating.vue'

const route = useRoute()
const slug = computed(() => route.params.slug as string)
const recipe = computed(() => getRecipeBySlug(slug.value))

const totalMins = computed(() => {
  const r = recipe.value
  if (!r) return 0
  return r.prepMins + r.cookMins
})

const printRecipe = () => {
  window.print()
}
</script>

<template>
  <div v-if="recipe" class="pb-8">
    <div class="border-b border-bayong bg-harina/40">
      <div class="mx-auto max-w-3xl px-4 py-6">
        <RouterLink
          to="/"
          class="inline-flex min-h-[44px] items-center gap-2 font-body text-small font-semibold text-terracotta hover:text-terracotta-dark"
        >
          <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
          </svg>
          Back to recipes
        </RouterLink>
      </div>
    </div>

    <article class="mx-auto max-w-3xl px-4 py-8 print:max-w-none print:py-4">
      <header class="print:break-inside-avoid">
        <div class="overflow-hidden rounded-card bg-harina shadow-card">
          <div class="aspect-[16/10] bg-bayong">
            <img
              :src="recipe.imageUrl"
              :alt="recipe.imageAlt"
              width="1200"
              height="750"
              class="h-full w-full object-cover"
            />
          </div>
          <div class="p-5 md:p-8">
            <div class="flex flex-wrap items-start justify-between gap-4">
              <h1 class="font-heading text-h1 text-uling">
                {{ recipe.title }}
              </h1>
              <div class="no-print flex flex-wrap gap-2">
                <button
                  type="button"
                  class="inline-flex min-h-[48px] items-center justify-center gap-2 rounded-btn bg-terracotta px-4 font-body text-small font-semibold text-white hover:bg-terracotta-dark active:scale-[0.98]"
                  @click="printRecipe"
                >
                  <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 9V2h12v7M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2M6 14h12v8H6v-8z" />
                  </svg>
                  Print / PDF
                </button>
                <button
                  type="button"
                  disabled
                  class="inline-flex min-h-[48px] cursor-not-allowed items-center justify-center rounded-btn border border-bayong bg-white/60 px-4 font-body text-small font-semibold text-kawayan"
                  title="Phase 2"
                >
                  Save
                </button>
              </div>
            </div>
            <p class="mt-3 text-body text-kawayan">
              {{ recipe.description }}
            </p>
            <div class="mt-4 flex flex-wrap items-center gap-3 text-small text-kawayan">
              <span class="tabular-nums">{{ totalMins }} min total</span>
              <span aria-hidden="true">·</span>
              <span>Prep {{ recipe.prepMins }} min</span>
              <span aria-hidden="true">·</span>
              <span>Cook {{ recipe.cookMins }} min</span>
              <span aria-hidden="true">·</span>
              <span>{{ recipe.difficulty }}</span>
            </div>
            <div class="mt-3">
              <StarRating :value="recipe.rating" :count="recipe.ratingCount" />
            </div>
            <div class="mt-4 flex flex-wrap gap-2">
              <span class="rounded-chip bg-white px-3 py-1 text-caption font-semibold uppercase tracking-wide text-kawayan ring-1 ring-bayong">
                {{ recipe.course }}
              </span>
              <span class="rounded-chip bg-dahon/15 px-3 py-1 text-caption font-semibold text-dahon">
                {{ recipe.region }}
              </span>
              <span class="rounded-chip bg-calamansi/20 px-3 py-1 text-caption font-semibold text-uling">
                {{ recipe.mainIngredient }}
              </span>
            </div>
          </div>
        </div>
      </header>

      <div class="mt-10 grid gap-10 md:grid-cols-5 print:mt-8">
        <section class="md:col-span-2 print:break-inside-avoid">
          <h2 class="font-heading text-h2 text-uling">Ingredients</h2>
          <ul class="mt-4 space-y-2 border-l-2 border-calamansi/40 pl-4">
            <li
              v-for="(line, i) in recipe.ingredients"
              :key="i"
              class="text-body text-uling"
            >
              {{ line }}
            </li>
          </ul>
        </section>
        <section class="md:col-span-3">
          <h2 class="font-heading text-h2 text-uling">Steps</h2>
          <ol class="mt-4 space-y-4">
            <li
              v-for="(step, i) in recipe.steps"
              :key="i"
              class="flex gap-4 print:break-inside-avoid"
            >
              <span
                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-terracotta font-body text-small font-bold text-white"
                aria-hidden="true"
              >
                {{ i + 1 }}
              </span>
              <p class="pt-1 text-body text-uling">
                {{ step }}
              </p>
            </li>
          </ol>
        </section>
      </div>

      <p class="no-print mt-12 rounded-card bg-dahon/5 p-4 text-small text-kawayan">
        Ratings, favorites, and PDF styling will connect to the backend in phase 2. Print uses your browser’s print dialog (save as PDF).
      </p>
    </article>
  </div>

  <div
    v-else
    class="mx-auto max-w-lg px-4 py-20 text-center"
  >
    <h1 class="font-heading text-h1 text-uling">Recipe not found</h1>
    <p class="mt-2 text-kawayan">
      This dish isn’t in the sample library yet.
    </p>
    <RouterLink
      to="/"
      class="mt-8 inline-flex min-h-[48px] items-center justify-center rounded-btn bg-terracotta px-6 font-body text-small font-semibold text-white hover:bg-terracotta-dark"
    >
      Go home
    </RouterLink>
  </div>
</template>

<style scoped>
@media print {
  .no-print {
    display: none !important;
  }
}
</style>
