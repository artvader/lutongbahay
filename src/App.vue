<script setup lang="ts">
import { RouterView } from 'vue-router'
import AppHeader from '@/components/AppHeader.vue'
import AppBottomNav from '@/components/AppBottomNav.vue'
</script>

<template>
  <div class="min-h-dvh flex flex-col bg-bigas">
    <AppHeader />
    <main id="main-content" class="flex-1 pb-[calc(4.5rem+env(safe-area-inset-bottom))] md:pb-8">
      <RouterView />
    </main>
    <AppBottomNav />
  </div>
</template>
