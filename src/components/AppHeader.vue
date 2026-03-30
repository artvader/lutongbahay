<script setup lang="ts">
import { ref } from 'vue'
import { RouterLink, useRoute } from 'vue-router'
import LogoMark from '@/components/LogoMark.vue'
import SearchOverlay from '@/components/SearchOverlay.vue'

const route = useRoute()
const searchOpen = ref(false)
</script>

<template>
  <header class="sticky top-0 z-40 border-b border-bayong bg-bigas/95 backdrop-blur-md">
    <a
      href="#main-content"
      class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-[100] focus:rounded-btn focus:bg-terracotta focus:px-4 focus:py-2 focus:text-white"
    >
      Skip to main content
    </a>
    <div class="mx-auto flex max-w-6xl items-center gap-4 px-4 py-3 md:grid md:grid-cols-[1fr_auto_1fr] md:items-center md:gap-6 md:py-4">
      <RouterLink
        to="/"
        class="min-h-[44px] min-w-[44px] shrink-0 focus:outline-none focus-visible:ring-2 focus-visible:ring-terracotta focus-visible:ring-offset-2"
        aria-label="Lutong Bahay home"
      >
        <LogoMark />
      </RouterLink>

      <!-- Desktop: styled search bar → /search page -->
      <RouterLink
        to="/search"
        class="hidden min-h-[48px] w-full max-w-xl items-center gap-3 rounded-btn border-[1.5px] border-bayong bg-white px-4 py-2.5 font-body text-small text-kawayan/70 shadow-sm transition duration-150 hover:border-terracotta/40 hover:text-kawayan md:flex"
      >
        <svg class="h-5 w-5 shrink-0 text-kawayan" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" aria-hidden="true">
          <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M11 18a7 7 0 100-14 7 7 0 000 14z" />
        </svg>
        <span>Search recipes, ingredients, regions…</span>
      </RouterLink>

      <nav class="ml-auto flex items-center gap-1 md:justify-end md:gap-2" aria-label="Primary">
        <!-- Mobile: search icon opens overlay -->
        <button
          type="button"
          class="flex min-h-[44px] min-w-[44px] items-center justify-center rounded-btn p-2 text-kawayan hover:bg-harina hover:text-terracotta md:hidden"
          aria-label="Search recipes"
          @click="searchOpen = true"
        >
          <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M11 18a7 7 0 100-14 7 7 0 000 14z" />
          </svg>
        </button>

        <RouterLink
          to="/"
          class="hidden rounded-btn px-3 py-2 font-body text-small font-semibold text-kawayan transition hover:bg-harina hover:text-uling md:inline-block"
          :class="{ 'text-terracotta underline decoration-2 decoration-terracotta underline-offset-4': route.name === 'home' }"
        >
          Home
        </RouterLink>
        <RouterLink
          to="/saved"
          class="hidden rounded-btn px-3 py-2 font-body text-small font-semibold text-kawayan transition hover:bg-harina hover:text-uling md:inline-block"
          :class="{ 'text-terracotta underline decoration-2 decoration-terracotta underline-offset-4': route.name === 'saved' }"
        >
          Saved
        </RouterLink>
      </nav>
    </div>
  </header>

  <SearchOverlay v-model:open="searchOpen" />
</template>
