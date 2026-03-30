<script setup lang="ts">
import { ref, computed } from 'vue'
import { filterGroups } from '@/data/recipes'
import type { Difficulty } from '@/types/recipe'

const query = defineModel<string>('query', { default: '' })

const props = defineProps<{
  courses: Set<string>
  regions: Set<string>
  difficulties: Set<Difficulty>
  ingredients: Set<string>
  resultCount?: number
  showSearch?: boolean
}>()

const showSearch = computed(() => props.showSearch !== false)

const emit = defineEmits<{
  toggleCourse: [value: string]
  toggleRegion: [value: string]
  toggleDifficulty: [value: Difficulty]
  toggleIngredient: [value: string]
  clear: []
}>()

const sheetOpen = ref(false)

const activeCount = computed(
  () =>
    props.courses.size +
    props.regions.size +
    props.difficulties.size +
    props.ingredients.size,
)

const chipBase =
  'min-h-[44px] min-w-[44px] touch-manipulation rounded-chip px-3 py-2 font-body text-small font-medium transition duration-150 ease-out focus:outline-none focus-visible:ring-2 focus-visible:ring-terracotta focus-visible:ring-offset-2 focus-visible:ring-offset-bigas'

const chipOff = 'bg-harina text-kawayan ring-1 ring-bayong hover:bg-white'
const chipOnCourse = 'bg-dahon text-white ring-1 ring-dahon'
const chipOnOther = 'bg-terracotta text-white ring-1 ring-terracotta'
</script>

<template>
  <section class="space-y-4" aria-labelledby="search-filters-heading">
    <h2 id="search-filters-heading" class="sr-only">Search and filter recipes</h2>

    <!-- Search input — only shown when showSearch is true (e.g. Search page) -->
    <div v-if="showSearch" class="relative">
      <label for="recipe-search" class="mb-1.5 block text-small font-semibold text-kawayan">
        Search recipes
      </label>
      <div class="relative">
        <span
          class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-kawayan"
          aria-hidden="true"
        >
          <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M11 18a7 7 0 100-14 7 7 0 000 14z" />
          </svg>
        </span>
        <input
          id="recipe-search"
          v-model="query"
          type="search"
          name="q"
          autocomplete="off"
          placeholder="Titles, ingredients, regions…"
          class="min-h-[48px] w-full rounded-btn border-[1.5px] border-bayong bg-white py-3 pl-11 pr-4 font-body text-body text-uling shadow-sm placeholder:text-kawayan/60 focus:border-terracotta focus:shadow-input-focus"
        />
      </div>
      <p class="mt-1.5 text-caption text-kawayan">
        Full search across the library ships with the CMS in phase 2 — this preview filters the sample set in your browser only.
      </p>
    </div>

    <!-- Filter trigger row — mobile only (always shown) -->
    <div class="flex items-center justify-between md:hidden">
      <p class="font-heading text-h3 text-uling">Browse by</p>
      <button
        type="button"
        class="relative inline-flex min-h-[44px] items-center gap-2 rounded-btn border-[1.5px] px-4 font-body text-small font-semibold shadow-sm transition"
        :class="activeCount > 0
          ? 'border-terracotta bg-terracotta/5 text-terracotta'
          : 'border-bayong bg-white text-uling hover:border-terracotta hover:text-terracotta'"
        @click="sheetOpen = true"
        aria-haspopup="dialog"
        :aria-label="`Filters${activeCount > 0 ? `, ${activeCount} active` : ''}`"
      >
        <svg class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3 4h18M7 8h10M11 12h2M9 16h6" />
        </svg>
        <span>Filters</span>
        <span
          v-if="activeCount > 0"
          class="flex h-5 w-5 items-center justify-center rounded-full bg-terracotta text-[11px] font-bold text-white"
        >{{ activeCount }}</span>
      </button>
    </div>

    <!-- Inline filter panel — desktop only -->
    <div class="hidden md:block space-y-4 rounded-card border border-bayong/80 bg-white/60 p-5 shadow-card backdrop-blur-sm">
      <div class="flex flex-wrap items-end justify-between gap-3">
        <p class="font-heading text-h3 text-uling">Filters</p>
        <button
          type="button"
          class="min-h-[44px] rounded-btn px-3 font-body text-small font-semibold text-terracotta underline decoration-bayong decoration-2 underline-offset-4 hover:text-terracotta-dark"
          @click="emit('clear')"
        >
          Clear all
        </button>
      </div>

      <div>
        <p class="mb-2 text-caption font-semibold uppercase tracking-wider text-kawayan">Course</p>
        <div class="flex flex-wrap gap-2">
          <button
            v-for="c in filterGroups.course" :key="c"
            type="button"
            :class="[chipBase, props.courses.has(c) ? chipOnCourse : chipOff]"
            @click="emit('toggleCourse', c)"
          >{{ c }}</button>
        </div>
      </div>

      <div>
        <p class="mb-2 text-caption font-semibold uppercase tracking-wider text-kawayan">Region</p>
        <div class="flex flex-wrap gap-2">
          <button
            v-for="r in filterGroups.region" :key="r"
            type="button"
            :class="[chipBase, props.regions.has(r) ? chipOnOther : chipOff]"
            @click="emit('toggleRegion', r)"
          >{{ r }}</button>
        </div>
      </div>

      <div>
        <p class="mb-2 text-caption font-semibold uppercase tracking-wider text-kawayan">Difficulty</p>
        <div class="flex flex-wrap gap-2">
          <button
            v-for="d in filterGroups.difficulty" :key="d"
            type="button"
            :class="[chipBase, props.difficulties.has(d) ? chipOnOther : chipOff]"
            @click="emit('toggleDifficulty', d)"
          >{{ d }}</button>
        </div>
      </div>

      <div>
        <p class="mb-2 text-caption font-semibold uppercase tracking-wider text-kawayan">Main ingredient</p>
        <div class="flex flex-wrap gap-2">
          <button
            v-for="ing in filterGroups.ingredient" :key="ing"
            type="button"
            :class="[chipBase, props.ingredients.has(ing) ? chipOnOther : chipOff]"
            @click="emit('toggleIngredient', ing)"
          >{{ ing }}</button>
        </div>
      </div>
    </div>

    <!-- Bottom sheet — mobile only -->
    <Teleport to="body">
      <Transition name="sheet">
        <div
          v-if="sheetOpen"
          class="md:hidden fixed inset-0 z-50 flex flex-col justify-end"
          role="dialog"
          aria-modal="true"
          aria-labelledby="filter-sheet-title"
        >
          <!-- Backdrop -->
          <div
            class="absolute inset-0 bg-uling/50 backdrop-blur-[2px]"
            @click="sheetOpen = false"
          />

          <!-- Sheet panel -->
          <div class="sheet-panel relative flex max-h-[85dvh] flex-col rounded-t-2xl bg-bigas shadow-2xl">
            <!-- Drag handle -->
            <div class="flex justify-center pt-3 pb-1" aria-hidden="true">
              <div class="h-1 w-10 rounded-full bg-bayong" />
            </div>

            <!-- Header -->
            <div class="flex items-center justify-between px-5 py-3 border-b border-bayong/40">
              <h3 id="filter-sheet-title" class="font-heading text-h3 text-uling">Filters</h3>
              <div class="flex items-center gap-3">
                <button
                  v-if="activeCount > 0"
                  type="button"
                  class="font-body text-small font-semibold text-terracotta underline decoration-bayong decoration-2 underline-offset-4"
                  @click="emit('clear')"
                >
                  Clear all
                </button>
                <button
                  type="button"
                  class="flex h-9 w-9 items-center justify-center rounded-full bg-harina text-kawayan hover:bg-bayong/30"
                  @click="sheetOpen = false"
                  aria-label="Close filters"
                >
                  <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                  </svg>
                </button>
              </div>
            </div>

            <!-- Scrollable filter content -->
            <div class="overflow-y-auto px-5 py-4 space-y-5">
              <div>
                <p class="mb-2 text-caption font-semibold uppercase tracking-wider text-kawayan">Course</p>
                <div class="flex flex-wrap gap-2">
                  <button
                    v-for="c in filterGroups.course" :key="c"
                    type="button"
                    :class="[chipBase, props.courses.has(c) ? chipOnCourse : chipOff]"
                    @click="emit('toggleCourse', c)"
                  >{{ c }}</button>
                </div>
              </div>

              <div>
                <p class="mb-2 text-caption font-semibold uppercase tracking-wider text-kawayan">Region</p>
                <div class="flex flex-wrap gap-2">
                  <button
                    v-for="r in filterGroups.region" :key="r"
                    type="button"
                    :class="[chipBase, props.regions.has(r) ? chipOnOther : chipOff]"
                    @click="emit('toggleRegion', r)"
                  >{{ r }}</button>
                </div>
              </div>

              <div>
                <p class="mb-2 text-caption font-semibold uppercase tracking-wider text-kawayan">Difficulty</p>
                <div class="flex flex-wrap gap-2">
                  <button
                    v-for="d in filterGroups.difficulty" :key="d"
                    type="button"
                    :class="[chipBase, props.difficulties.has(d) ? chipOnOther : chipOff]"
                    @click="emit('toggleDifficulty', d)"
                  >{{ d }}</button>
                </div>
              </div>

              <div>
                <p class="mb-2 text-caption font-semibold uppercase tracking-wider text-kawayan">Main ingredient</p>
                <div class="flex flex-wrap gap-2">
                  <button
                    v-for="ing in filterGroups.ingredient" :key="ing"
                    type="button"
                    :class="[chipBase, props.ingredients.has(ing) ? chipOnOther : chipOff]"
                    @click="emit('toggleIngredient', ing)"
                  >{{ ing }}</button>
                </div>
              </div>
            </div>

            <!-- Footer CTA -->
            <div class="px-5 py-4 border-t border-bayong/40">
              <button
                type="button"
                class="w-full min-h-[48px] rounded-btn bg-terracotta font-body text-small font-semibold text-white shadow-card hover:bg-terracotta-dark active:scale-[0.98] transition"
                @click="sheetOpen = false"
              >
                Show {{ props.resultCount !== undefined ? `${props.resultCount} ` : '' }}results
              </button>
            </div>
          </div>
        </div>
      </Transition>
    </Teleport>
  </section>
</template>

<style scoped>
.sheet-enter-active,
.sheet-leave-active {
  transition: opacity 0.25s ease;
}
.sheet-enter-active .sheet-panel,
.sheet-leave-active .sheet-panel {
  transition: transform 0.3s cubic-bezier(0.32, 0.72, 0, 1);
}
.sheet-enter-from,
.sheet-leave-to {
  opacity: 0;
}
.sheet-enter-from .sheet-panel,
.sheet-leave-to .sheet-panel {
  transform: translateY(100%);
}
</style>
