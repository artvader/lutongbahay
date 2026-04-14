<script setup lang="ts">
import { ref, computed, onMounted, onBeforeUnmount } from 'vue'
import { useRouter } from 'vue-router'
import { useRecipes } from '@/composables/useRecipes'

const router = useRouter()
const { recipes, ensureRecipesLoaded } = useRecipes()
void ensureRecipesLoaded()
const query = ref('')
const isFocused = ref(false)
const containerRef = ref<HTMLElement | null>(null)
const inputEl = ref<HTMLInputElement | null>(null)

function clearSearch() {
  query.value = ''
  inputEl.value?.focus()
}

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
    .slice(0, 5) // top 5
})

const hasQuery = computed(() => query.value.trim().length > 0)
const isOpen = computed(() => isFocused.value && hasQuery.value)

function goToRecipe(slug: string) {
  isFocused.value = false
  query.value = ''
  router.push(`/recipe/${slug}`)
}

function goToSearch() {
  isFocused.value = false
  const qStr = query.value
  query.value = ''
  router.push({ path: '/browse', query: qStr ? { q: qStr } : {} })
}

function handleClickOutside(e: MouseEvent) {
  if (containerRef.value && !containerRef.value.contains(e.target as Node)) {
    isFocused.value = false
  }
}

onMounted(() => {
  document.addEventListener('mousedown', handleClickOutside)
})

onBeforeUnmount(() => {
  document.removeEventListener('mousedown', handleClickOutside)
})
</script>

<template>
  <div ref="containerRef" class="relative hidden md:block md:w-[36rem] lg:w-[42rem] xl:w-[46rem]">
    <div class="relative">
      <span class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-kawayan" aria-hidden="true">
        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
          <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M11 18a7 7 0 100-14 7 7 0 000 14z" />
        </svg>
      </span>
      <input
        ref="inputEl"
        v-model="query"
        type="search"
        autocomplete="off"
        placeholder="Search recipes, ingredients, regions…"
        class="search-input min-h-[48px] w-full rounded-btn border-[1.5px] border-bayong bg-white py-2.5 pl-11 pr-10 font-body text-small text-uling shadow-sm placeholder:text-kawayan/70 transition duration-150 hover:border-terracotta/40 focus:border-terracotta focus:outline-none focus:ring-2 focus:ring-terracotta/20"
        @focus="isFocused = true"
        @keydown.enter="goToSearch"
      />
      <button
        v-if="query.length > 0"
        type="button"
        class="absolute right-3 top-1/2 -translate-y-1/2 rounded-full p-1 text-kawayan hover:bg-harina hover:text-terracotta focus:outline-none focus-visible:ring-2 focus-visible:ring-terracotta"
        aria-label="Clear search"
        @click="clearSearch"
      >
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
    </div>

    <!-- Dropdown -->
    <Transition name="dropdown">
      <div
        v-if="isOpen"
        class="absolute left-1/2 -translate-x-1/2 top-[calc(100%+8px)] z-50 w-[360px] overflow-hidden rounded-card border border-bayong bg-white shadow-card"
      >
        <ul v-if="results.length" class="divide-y divide-bayong/30 pb-1">
          <li v-for="r in results" :key="r.id">
            <button
              type="button"
              class="flex w-full items-start gap-4 p-3 text-left transition hover:bg-harina"
              @click="goToRecipe(r.slug)"
            >
              <img
                :src="r.imageUrl"
                :alt="r.imageAlt"
                class="h-14 w-14 shrink-0 rounded-lg object-cover"
              />
              <div class="min-w-0 flex-1 pt-0.5">
                <p class="truncate font-body text-small font-semibold text-uling">{{ r.title }}</p>
                <p class="mt-0.5 line-clamp-2 text-caption text-kawayan">{{ r.description }}</p>
              </div>
            </button>
          </li>
          <li>
            <button
              type="button"
              class="flex w-full items-center justify-between px-4 py-3 font-body text-small font-semibold text-terracotta hover:bg-harina transition border-t border-bayong/30 mt-1"
              @click="goToSearch"
            >
              <span>See all results for "{{ query.trim() }}"</span>
              <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
              </svg>
            </button>
          </li>
        </ul>
        
        <div v-else class="px-4 py-8 text-center">
          <p class="font-heading text-h3 text-uling">No matches</p>
          <p class="mt-1 text-small text-kawayan">Try a different ingredient or dish name.</p>
        </div>
      </div>
    </Transition>
  </div>
</template>

<style scoped>
.dropdown-enter-active,
.dropdown-leave-active {
  transition: opacity 0.15s ease, transform 0.15s ease;
}
.dropdown-enter-from,
.dropdown-leave-to {
  opacity: 0;
  transform: translateY(-4px);
}

.search-input::-webkit-search-cancel-button {
  -webkit-appearance: none;
  appearance: none;
}
</style>
