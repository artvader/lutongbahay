<script setup lang="ts">
import { computed } from 'vue'

export type ActiveFilter = { type: string; value: string }

const props = defineProps<{
  filters: ActiveFilter[]
}>()

const emit = defineEmits<{
  (e: 'remove', f: ActiveFilter): void
  (e: 'open'): void
}>()

const MAX_CHIPS = 7

const visibleCount = computed(() => {
  // If we only have 8 items, showing "7 items + 1 more" is silly.
  // Better to just show all 8 if it's borderline, or clamp strictly to 7.
  // We'll clamp strictly to 7 to guarantee layout safety.
  if (props.filters.length <= MAX_CHIPS) {
    return props.filters.length
  }
  return MAX_CHIPS
})
</script>

<template>
  <div class="w-full">
    <div class="flex flex-wrap gap-2">
      <button
        v-for="f in filters.slice(0, visibleCount)"
        :key="`vis-${f.type}-${f.value}`"
        type="button"
        @click="emit('remove', f)"
        class="inline-flex items-center gap-1 rounded-chip border-[1.5px] border-terracotta bg-terracotta/5 px-3 py-1.5 font-body text-small font-medium text-terracotta transition hover:bg-terracotta hover:text-white"
        :aria-label="`Remove ${f.value} filter`"
      >
        <span>{{ f.value }}</span>
        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
      <button
        v-if="filters.length > visibleCount"
        type="button"
        class="inline-flex items-center rounded-chip border-[1.5px] border-bayong bg-white px-3 py-1.5 font-body text-small font-medium text-uling shadow-sm transition hover:border-terracotta hover:text-terracotta"
        @click="emit('open')"
      >
        +{{ filters.length - visibleCount }} more
      </button>
    </div>
  </div>
</template>
