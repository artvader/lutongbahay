<script setup lang="ts">
import { computed, ref, watch, onMounted, onBeforeUnmount } from 'vue'
import { RouterLink } from 'vue-router'
import { Swiper, SwiperSlide } from 'swiper/vue'
import { Autoplay, Pagination } from 'swiper/modules'
import 'swiper/css'
import 'swiper/css/pagination'
import { useRecipeBrowse } from '@/composables/useRecipeBrowse'
import { useRecipes } from '@/composables/useRecipes'
import SearchAndFilters from '@/components/SearchAndFilters.vue'
import RecipeCard from '@/components/RecipeCard.vue'

const swiperModules = [Autoplay, Pagination]
const { recipes, ensureRecipesLoaded } = useRecipes()
void ensureRecipesLoaded()

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

const featured = computed(() => recipes.value.filter((r) => r.featured))

// ── Infinite scroll ──────────────────────────────────────────────
const getPageSize = () => {
  if (typeof window === 'undefined') return 6
  if (window.innerWidth >= 1024) return 9
  if (window.innerWidth >= 640) return 8
  return 6
}

const pageSize = ref(getPageSize())
const page = ref(1)

const handleResize = () => {
  pageSize.value = getPageSize()
}

onMounted(() => {
  window.addEventListener('resize', handleResize)
})

onBeforeUnmount(() => {
  window.removeEventListener('resize', handleResize)
})

const visibleRecipes = computed(() =>
  filteredRecipes.value.slice(0, page.value * pageSize.value),
)
const hasMore = computed(
  () => visibleRecipes.value.length < filteredRecipes.value.length,
)

// Reset to first page whenever filters/search change
watch(filteredRecipes, () => { page.value = 1 })

const sentinel = ref<HTMLElement | null>(null)
let observer: IntersectionObserver | null = null

onMounted(() => {
  observer = new IntersectionObserver(
    (entries) => {
      if (entries[0].isIntersecting && hasMore.value) {
        page.value++
      }
    },
    { rootMargin: '200px' },
  )
  if (sentinel.value) observer.observe(sentinel.value)
})

onBeforeUnmount(() => observer?.disconnect())
</script>

<template>
  <div>
    <section
      class="relative overflow-hidden border-b border-bayong/60"
      aria-labelledby="hero-heading"
    >
      <!-- Background image -->
      <img
        src="/images/hero-image.png"
        alt=""
        aria-hidden="true"
        class="absolute inset-0 h-full w-full object-cover object-center"
        loading="eager"
      />

      <!-- Mobile overlay: uniform dark veil -->
      <div class="absolute inset-0 bg-black/60 md:hidden" aria-hidden="true" />

      <!-- Desktop overlay: left-to-right gradient scrim so food shows on the right -->
      <div
        class="absolute inset-0 hidden md:block"
        style="background: linear-gradient(to right, rgba(0,0,0,0.78) 0%, rgba(0,0,0,0.65) 40%, rgba(0,0,0,0.25) 70%, rgba(0,0,0,0.08) 100%)"
        aria-hidden="true"
      />

      <!-- Content -->
      <div class="relative mx-auto max-w-6xl px-4 py-16 md:py-24">
        <div class="max-w-lg">
          <p class="font-body text-caption font-semibold uppercase tracking-wider text-calamansi">
            Lutong Bahay
          </p>
          <h1
            id="hero-heading"
            class="mt-2 font-heading text-hero text-white md:text-[2.75rem]"
          >
            Home cooking, honored.
          </h1>
          <p class="mt-3 font-body text-body text-white/80 md:text-lg">
            <span class="font-semibold text-white">Luto na tayo.</span>
            Curated Filipino recipes — step by step, kitchen-tested, ready for your stove.
          </p>
          <div class="mt-8 flex flex-wrap gap-3">
            <RouterLink
              to="/browse"
              class="inline-flex min-h-[48px] min-w-[44px] items-center justify-center rounded-btn bg-terracotta px-6 font-body text-small font-semibold text-white shadow-card transition duration-150 hover:bg-terracotta-dark active:scale-[0.98]"
            >
              Explore all recipes
            </RouterLink>
            <a
              href="#recipes"
              class="inline-flex min-h-[48px] min-w-[44px] items-center justify-center rounded-btn border-[1.5px] border-white/70 bg-transparent px-6 font-body text-small font-semibold text-white transition duration-150 hover:bg-white hover:text-uling active:scale-[0.98]"
            >
              Browse recipes
            </a>
          </div>
        </div>
      </div>
    </section>

    <section
      v-if="featured.length"
      class="border-b border-bayong/40 bg-bigas py-10"
      aria-labelledby="featured-heading"
    >
      <div class="mx-auto max-w-6xl px-4">
        <div class="mb-6 flex items-end justify-between gap-4">
          <h2 id="featured-heading" class="font-heading text-h2 text-uling">
            Featured
          </h2>
          <span class="rounded-chip bg-calamansi/25 px-3 py-1 font-body text-caption font-semibold text-uling">
            Editor’s picks
          </span>
        </div>
        <Swiper
          :modules="swiperModules"
          :slides-per-view="1"
          :space-between="16"
          :breakpoints="{
            640: { slidesPerView: 2 },
            1024: { slidesPerView: 3 },
          }"
          :autoplay="{ delay: 3500, disableOnInteraction: false, pauseOnMouseEnter: true }"
          :pagination="{ clickable: true }"
          loop
          class="featured-swiper !pb-10"
        >
          <SwiperSlide v-for="r in featured" :key="r.id">
            <RecipeCard :recipe="r" />
          </SwiperSlide>
        </Swiper>
      </div>
    </section>

    <div id="recipes" class="mx-auto max-w-6xl scroll-mt-24 px-4 py-10 md:py-14">
      <div class="md:flex md:items-start md:gap-8">
        <aside class="md:w-[320px] md:shrink-0 md:sticky md:top-24 max-md:mb-10">
          <SearchAndFilters
            v-model:query="query"
            :courses="courses"
            :regions="regions"
            :difficulties="difficulties"
            :ingredients="ingredients"
            :result-count="filteredRecipes.length"
            :show-search="false"
            @toggle-course="toggleCourse"
            @toggle-region="toggleRegion"
            @toggle-difficulty="toggleDifficulty"
            @toggle-ingredient="toggleIngredient"
            @clear="clearFilters"
          />
        </aside>

        <div class="md:flex-1 w-full min-w-0">
          <div class="mb-6 flex flex-wrap items-baseline justify-between gap-2">
            <h2 class="font-heading text-h2 text-uling">All recipes</h2>
            <p class="text-small text-kawayan tabular-nums">
              {{ visibleRecipes.length }} of {{ filteredRecipes.length }} shown
            </p>
          </div>
          <div
            v-if="filteredRecipes.length === 0"
            class="rounded-card border border-dashed border-bayong bg-harina/50 px-6 py-12 text-center"
          >
            <p class="font-heading text-h3 text-uling">No matches yet</p>
            <p class="mt-2 text-small text-kawayan">
              Try clearing filters or searching another ingredient.
            </p>
            <button
              type="button"
              class="mt-6 min-h-[48px] rounded-btn bg-terracotta px-6 font-body text-small font-semibold text-white hover:bg-terracotta-dark"
              @click="clearFilters"
            >
              Clear filters
            </button>
          </div>
          <ul
            v-else
            class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3"
          >
            <li v-for="r in visibleRecipes" :key="r.id" class="h-full">
              <RecipeCard :recipe="r" hide-featured-badge />
            </li>
          </ul>

          <!-- Infinite scroll sentinel -->
          <div ref="sentinel" class="h-px" aria-hidden="true" />

          <!-- Loading indicator -->
          <div v-if="hasMore" class="mt-8 flex justify-center">
            <div class="flex gap-1.5">
              <span class="h-2 w-2 animate-bounce rounded-full bg-terracotta [animation-delay:-0.3s]" />
              <span class="h-2 w-2 animate-bounce rounded-full bg-terracotta [animation-delay:-0.15s]" />
              <span class="h-2 w-2 animate-bounce rounded-full bg-terracotta" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style>
.featured-swiper .swiper-pagination-bullet {
  background: #b45309;
  opacity: 0.35;
}
.featured-swiper .swiper-pagination-bullet-active {
  background: #b45309;
  opacity: 1;
}
</style>
