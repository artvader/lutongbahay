<script setup lang="ts">
import { computed, useId } from 'vue'

const props = withDefaults(
  defineProps<{
    value: number
    count?: number
    size?: 'sm' | 'md'
  }>(),
  { size: 'md' },
)

const gid = useId()
const stars = computed(() => {
  const out: Array<'full' | 'half' | 'empty'> = []
  let remaining = props.value
  for (let i = 0; i < 5; i++) {
    if (remaining >= 1) {
      out.push('full')
      remaining -= 1
    } else if (remaining >= 0.25) {
      out.push('half')
      remaining = 0
    } else {
      out.push('empty')
    }
  }
  return out
})

const starClass = computed(() =>
  props.size === 'sm' ? 'h-3.5 w-3.5' : 'h-4 w-4',
)
</script>

<template>
  <div
    class="flex flex-wrap items-center gap-1"
    :aria-label="`Rated ${value} out of 5 stars`"
  >
    <span class="flex text-calamansi" role="img">
      <template v-for="(kind, i) in stars" :key="i">
        <svg
          v-if="kind === 'full'"
          :class="starClass"
          viewBox="0 0 20 20"
          fill="currentColor"
          aria-hidden="true"
        >
          <path
            d="M10 1.5l2.47 5.01 5.53.8-4 3.9.94 5.5L10 13.9l-4.94 2.6.94-5.5-4-3.9 5.53-.8L10 1.5z"
          />
        </svg>
        <svg
          v-else-if="kind === 'half'"
          :class="starClass"
          viewBox="0 0 20 20"
          aria-hidden="true"
        >
          <defs>
            <linearGradient :id="`${gid}-half`" x1="0" x2="1" y1="0" y2="0">
              <stop offset="50%" stop-color="currentColor" />
              <stop offset="50%" stop-color="#D9CDBF" />
            </linearGradient>
          </defs>
          <path
            :fill="`url(#${gid}-half)`"
            d="M10 1.5l2.47 5.01 5.53.8-4 3.9.94 5.5L10 13.9l-4.94 2.6.94-5.5-4-3.9 5.53-.8L10 1.5z"
          />
        </svg>
        <svg
          v-else
          :class="starClass"
          viewBox="0 0 20 20"
          fill="none"
          stroke="#D9CDBF"
          stroke-width="1.2"
          aria-hidden="true"
        >
          <path
            d="M10 1.5l2.47 5.01 5.53.8-4 3.9.94 5.5L10 13.9l-4.94 2.6.94-5.5-4-3.9 5.53-.8L10 1.5z"
          />
        </svg>
      </template>
    </span>
    <span v-if="count != null" class="text-small text-kawayan tabular-nums">
      ({{ count }})
    </span>
  </div>
</template>
