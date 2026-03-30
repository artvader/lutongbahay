<script setup lang="ts">
import { RouterLink } from 'vue-router'
</script>

<template>
  <div class="mx-auto max-w-lg px-4 py-16 text-center md:py-24">
    <div
      class="mx-auto mb-6 flex h-16 w-16 items-center justify-center rounded-full bg-harina shadow-card"
      aria-hidden="true"
    >
      <svg class="h-8 w-8 text-calamansi" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
        <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.636l1.318-1.318a4.5 4.5 0 116.364 6.364L12 21.364l-7.682-7.682a4.5 4.5 0 010-6.364z" />
      </svg>
    </div>
    <h1 class="font-heading text-h1 text-uling">Saved recipes</h1>
    <p class="mt-3 text-body text-kawayan">
      Favorites will live here — stored on your device for v1, with optional accounts later. The UI shell is ready for phase 2.
    </p>
    <RouterLink
      to="/"
      class="mt-8 inline-flex min-h-[48px] items-center justify-center rounded-btn bg-terracotta px-6 font-body text-small font-semibold text-white transition hover:bg-terracotta-dark"
    >
      Explore recipes
    </RouterLink>
  </div>
</template>
