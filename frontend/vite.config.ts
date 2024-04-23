import { fileURLToPath, URL } from 'node:url'

import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [
    vue(),
  ],
  server: {
    hmr: {
        host: 'localhost',
    },
    watch: {
      // when running container in wsl2, polling is necessary
      // regular file watchers do not work
      usePolling: true,
      interval: 1000,
    }
  },
  resolve: {
    alias: {
      '@': fileURLToPath(new URL('./src', import.meta.url))
    }
  }
})
