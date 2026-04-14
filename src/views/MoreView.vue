<script setup lang="ts">
import { RouterLink } from 'vue-router'
import LogoMark from '@/components/LogoMark.vue'
</script>

<template>
  <div class="mx-auto max-w-2xl px-4 py-12 md:py-16">
    <div class="rounded-card border border-bayong bg-white p-6 shadow-card md:p-8">
      <LogoMark class="justify-center" />
      <h1 class="mt-6 text-center font-heading text-h1 text-uling">
        About this preview
      </h1>
      <p class="mt-4 text-center text-body text-kawayan">
        Lutong Bahay is a curated Filipino recipe platform. This build is a static front-end preview: real content, search, and ratings will connect to the CMS and API in phase 2.
      </p>
      <ul class="mt-8 space-y-3 text-small text-kawayan">
        <li class="flex gap-2">
          <span class="text-terracotta" aria-hidden="true">●</span>
          <span><strong class="text-uling">Mission:</strong> Authentic home cooking, clear steps, mobile-first.</span>
        </li>
        <li class="flex gap-2">
          <span class="text-terracotta" aria-hidden="true">●</span>
          <span><strong class="text-uling">Coming:</strong> Full-text search, 100 recipes, PDF export polish, favorites.</span>
        </li>
      </ul>
      <div class="mt-10 flex flex-wrap justify-center gap-3">
        <RouterLink
          to="/browse"
          class="inline-flex min-h-[48px] items-center justify-center rounded-btn bg-terracotta px-5 font-body text-small font-semibold text-white hover:bg-terracotta-dark"
        >
          Try browse UI
        </RouterLink>
        <RouterLink
          to="/"
          class="inline-flex min-h-[48px] items-center justify-center rounded-btn border-[1.5px] border-terracotta px-5 font-body text-small font-semibold text-terracotta hover:bg-terracotta hover:text-white"
        >
          Home
        </RouterLink>
      </div>
    </div>
  </div>
</template>
