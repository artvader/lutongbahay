import { ref } from 'vue'

const isSearchOpen = ref(false)

export function useSearchOverlay() {
  return { isSearchOpen }
}
