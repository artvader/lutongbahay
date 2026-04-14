<script setup lang="ts">
import { RouterLink, useRoute } from 'vue-router'
import LogoMark from '@/components/LogoMark.vue'
import SearchOverlay from '@/components/SearchOverlay.vue'
import DesktopSearch from '@/components/DesktopSearch.vue'
import { useSearchOverlay } from '@/composables/useSearchOverlay'

const route = useRoute()
const { isSearchOpen } = useSearchOverlay()
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
      <DesktopSearch />

      <nav class="ml-auto flex items-center gap-1 md:justify-end md:gap-2" aria-label="Primary">

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

  <SearchOverlay />
</template>
