<script setup lang="ts">
import { ref, computed, watch, nextTick } from 'vue'
import { useRouter } from 'vue-router'
import { useSearchOverlay } from '@/composables/useSearchOverlay'
import { useRecipes } from '@/composables/useRecipes'

const { isSearchOpen } = useSearchOverlay()
const { recipes, ensureRecipesLoaded } = useRecipes()
void ensureRecipesLoaded()

const router = useRouter()
const query = ref('')
const inputEl = ref<HTMLInputElement | null>(null)

watch(
  () => isSearchOpen.value,
  async (val) => {
    if (val) {
      await nextTick()
      inputEl.value?.focus()
    } else {
      query.value = ''
    }
  },
)

const results = computed(() => {
  const q = query.value.trim().toLowerCase()
  if (!q) return []
  return recipes.value
    .filter((r) => {
      const hay = [r.title, r.description, r.region, r.course, ...r.ingredients]
        .join(' ')
        .toLowerCase()
      return hay.includes(q)
    })
    .slice(0, 6)
})

function close() {
  isSearchOpen.value = false
}

function goToRecipe(slug: string) {
  close()
  router.push(`/recipe/${slug}`)
}

function goToSearch() {
  close()
  router.push({ path: '/browse', query: query.value ? { q: query.value } : {} })
}
</script>

<template>
  <Teleport to="body">
    <Transition name="overlay">
      <div
        v-if="isSearchOpen"
        class="md:hidden fixed inset-0 z-50 flex flex-col bg-bigas"
        role="dialog"
        aria-modal="true"
        aria-label="Search recipes"
      >
        <!-- Input bar -->
        <div class="flex items-center gap-3 border-b border-bayong px-4 py-3">
          <div class="relative flex-1">
            <span class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-kawayan" aria-hidden="true">
              <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M11 18a7 7 0 100-14 7 7 0 000 14z" />
              </svg>
            </span>
            <input
              ref="inputEl"
              v-model="query"
              type="search"
              autocomplete="off"
              autocorrect="off"
              spellcheck="false"
              placeholder="Recipes, ingredients, regions…"
              class="min-h-[48px] w-full rounded-btn border-[1.5px] border-bayong bg-white py-3 pl-11 pr-4 font-body text-body text-uling placeholder:text-kawayan/60 focus:border-terracotta focus:outline-none"
              @keydown.enter="goToSearch"
              @keydown.escape="close"
            />
          </div>
          <button
            type="button"
            class="min-h-[44px] shrink-0 rounded-btn px-3 font-body text-small font-semibold text-terracotta"
            @click="close"
          >
            Cancel
          </button>
        </div>

        <!-- Results -->
        <div class="flex-1 overflow-y-auto">
          <!-- Quick results -->
          <ul v-if="results.length" class="divide-y divide-bayong/30">
            <li v-for="r in results" :key="r.id">
              <button
                type="button"
                class="flex w-full items-center gap-4 px-4 py-3 text-left transition hover:bg-harina active:bg-harina"
                @click="goToRecipe(r.slug)"
              >
                <img
                  :src="r.imageUrl"
                  :alt="r.imageAlt"
                  class="h-12 w-12 shrink-0 rounded-lg object-cover"
                />
                <div class="min-w-0">
                  <p class="truncate font-body text-small font-semibold text-uling">{{ r.title }}</p>
                  <p class="text-caption text-kawayan">{{ r.course }} · {{ r.region }}</p>
                </div>
                <svg class="ml-auto h-4 w-4 shrink-0 text-bayong" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
              </button>
            </li>
          </ul>

          <!-- See all results -->
          <button
            v-if="query.trim() && results.length"
            type="button"
            class="flex w-full items-center justify-between px-4 py-3 font-body text-small font-semibold text-terracotta hover:bg-harina border-t border-bayong/30"
            @click="goToSearch"
          >
            <span>See all results for "{{ query.trim() }}"</span>
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
            </svg>
          </button>

          <!-- No results -->
          <div
            v-if="query.trim() && results.length === 0"
            class="px-4 py-12 text-center"
          >
            <p class="font-heading text-h3 text-uling">No matches</p>
            <p class="mt-1 text-small text-kawayan">Try a different ingredient or dish name.</p>
          </div>

          <!-- Idle state -->
          <div v-if="!query.trim()" class="px-4 py-6">
            <p class="mb-3 text-caption font-semibold uppercase tracking-wider text-kawayan">Try searching for</p>
            <div class="flex flex-wrap gap-2">
              <button
                v-for="hint in ['Adobo', 'Pork', 'Soup', 'Visayas', 'Easy', 'Dessert']"
                :key="hint"
                type="button"
                class="rounded-chip bg-harina px-3 py-2 font-body text-small font-medium text-kawayan ring-1 ring-bayong hover:bg-white"
                @click="query = hint"
              >
                {{ hint }}
              </button>
            </div>
          </div>
        </div>
      </div>
    </Transition>
  </Teleport>
</template>

<style scoped>
.overlay-enter-active {
  transition: opacity 0.18s ease, transform 0.22s cubic-bezier(0.32, 0.72, 0, 1);
}
.overlay-leave-active {
  transition: opacity 0.15s ease, transform 0.18s ease-in;
}
.overlay-enter-from {
  opacity: 0;
  transform: translateY(-8px);
}
.overlay-leave-to {
  opacity: 0;
  transform: translateY(-8px);
}
</style>
