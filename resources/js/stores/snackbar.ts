import { defineStore } from 'pinia'
import { ref } from 'vue'
import type { SnackbarMessage } from '@/plugins/snackbar'

export const useSnackbarStore = defineStore('snackbar', () => {
  const messages = ref<SnackbarMessage[]>([])

  const showMessage = (item: SnackbarMessage) => {
    const defaults: Partial<SnackbarMessage> = {
      color: 'info',
      timeout: 5000
    }

    messages.value.push({
      ...defaults,
      ...item
    } as SnackbarMessage)
  }

  return {
    messages,
    showMessage
  }
})
