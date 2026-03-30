<script setup lang="ts">
import { RouterLink, useRoute } from 'vue-router'

const route = useRoute()

type Tab = { name: string; to: string; label: string; match: string[] }

const tabs: Tab[] = [
  { name: 'home', to: '/', label: 'Home', match: ['home'] },
  { name: 'search', to: '/search', label: 'Search', match: ['search'] },
  { name: 'saved', to: '/saved', label: 'Saved', match: ['saved'] },
  { name: 'more', to: '/more', label: 'More', match: ['more'] },
]

const isActive = (tab: Tab) => tab.match.some((m) => route.name === m)
</script>

<template>
  <nav
    class="fixed bottom-0 left-0 right-0 z-50 border-t border-bayong bg-white/95 pb-[env(safe-area-inset-bottom)] backdrop-blur-md md:hidden"
    aria-label="Main navigation"
  >
    <ul class="mx-auto flex max-w-lg items-stretch justify-around gap-1 px-2 pt-1">
      <li v-for="tab in tabs" :key="tab.name" class="flex-1">
        <RouterLink
          :to="tab.to"
          class="flex min-h-[52px] flex-col items-center justify-center gap-0.5 rounded-lg px-2 py-1 font-body text-caption font-semibold transition duration-150 active:scale-[0.98]"
          :class="
            isActive(tab)
              ? 'text-terracotta'
              : 'text-kawayan hover:text-uling'
          "
        >
          <template v-if="tab.name === 'home'">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3 10.5L12 3l9 7.5V21a1 1 0 01-1 1h-5v-7H9v7H4a1 1 0 01-1-1v-10.5z" />
            </svg>
          </template>
          <template v-else-if="tab.name === 'search'">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
              <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M11 18a7 7 0 100-14 7 7 0 000 14z" />
            </svg>
          </template>
          <template v-else-if="tab.name === 'saved'">
            <svg class="h-6 w-6" :fill="isActive(tab) ? 'currentColor' : 'none'" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
              <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.636l1.318-1.318a4.5 4.5 0 116.364 6.364L12 21.364l-7.682-7.682a4.5 4.5 0 010-6.364z" />
            </svg>
          </template>
          <template v-else>
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
              <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h10" />
            </svg>
          </template>
          <span>{{ tab.label }}</span>
        </RouterLink>
      </li>
    </ul>
  </nav>
</template>
