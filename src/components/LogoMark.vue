<script setup lang="ts">
type Props = {
  variant?: 'horizontal' | 'icon'
  class?: string
}

const props = withDefaults(defineProps<Props>(), {
  variant: 'horizontal',
  class: '',
})
</script>

<template>
  <div :class="['flex items-center gap-2', props.class]">
    <svg
      v-if="variant === 'horizontal' || variant === 'icon'"
      class="shrink-0 text-terracotta"
      :class="variant === 'icon' ? 'h-9 w-9' : 'h-10 w-10'"
      viewBox="0 0 40 40"
      fill="none"
      xmlns="http://www.w3.org/2000/svg"
      aria-hidden="true"
    >
      <path
        d="M12 26c0-5 3.2-9 8-9s8 4 8 9"
        stroke="currentColor"
        stroke-width="2"
        stroke-linecap="round"
      />
      <path d="M9 26h22" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
      <path
        d="M20 9c1.2 2.5 2.5 4.5 2 7"
        stroke="#E8A838"
        stroke-width="1.8"
        stroke-linecap="round"
      />
    </svg>
    <span
      v-if="variant === 'horizontal'"
      class="font-heading text-h3 tracking-tight"
    >
      <span class="text-terracotta">Lutong</span>
      <span class="text-uling"> Bahay</span>
    </span>
  </div>
</template>
