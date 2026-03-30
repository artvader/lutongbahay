<script setup lang="ts">
import { RouterLink } from 'vue-router'
import type { Recipe } from '@/types/recipe'
import StarRating from '@/components/StarRating.vue'

defineProps<{
  recipe: Recipe
}>()

const totalMins = (r: Recipe) => r.prepMins + r.cookMins
</script>

<template>
  <article
    class="group overflow-hidden rounded-card bg-harina shadow-card transition duration-150 ease-out hover:-translate-y-0.5 hover:shadow-card-hover"
  >
    <RouterLink
      :to="{ name: 'recipe', params: { slug: recipe.slug } }"
      class="block focus:outline-none focus-visible:ring-2 focus-visible:ring-terracotta focus-visible:ring-offset-2 focus-visible:ring-offset-bigas"
    >
      <div class="aspect-[16/10] overflow-hidden bg-bayong">
        <img
          :src="recipe.imageUrl"
          :alt="recipe.imageAlt"
          loading="lazy"
          width="800"
          height="500"
          class="h-full w-full object-cover transition duration-300 group-hover:scale-[1.03]"
        />
      </div>
      <div class="p-4">
        <div v-if="recipe.featured" class="mb-2 inline-flex rounded-chip bg-calamansi px-3 py-0.5 font-body text-caption font-semibold uppercase tracking-wider text-uling">
          Featured
        </div>
        <h2 class="font-heading text-lg text-uling group-hover:text-terracotta-dark">
          {{ recipe.title }}
        </h2>
        <p class="mt-1 line-clamp-2 text-small text-kawayan">
          {{ recipe.description }}
        </p>
        <div
          class="mt-3 flex flex-wrap items-center gap-x-3 gap-y-1 border-t border-bayong pt-3 text-small text-kawayan"
        >
          <span class="tabular-nums">{{ totalMins(recipe) }} min</span>
          <span class="text-bayong" aria-hidden="true">·</span>
          <span>{{ recipe.difficulty }}</span>
          <span class="text-bayong" aria-hidden="true">·</span>
          <StarRating :value="recipe.rating" :count="recipe.ratingCount" size="sm" />
        </div>
        <div class="mt-3 flex flex-wrap gap-2">
          <span
            class="rounded-chip bg-white/80 px-2.5 py-0.5 text-caption font-medium uppercase tracking-wide text-kawayan ring-1 ring-bayong"
          >
            {{ recipe.course }}
          </span>
          <span
            class="rounded-chip bg-dahon/10 px-2.5 py-0.5 text-caption font-medium text-dahon"
          >
            {{ recipe.region }}
          </span>
        </div>
      </div>
    </RouterLink>
  </article>
</template>
