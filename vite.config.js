import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import path from 'path'
import fs from 'fs'

const assetsDir = path.resolve(__dirname, 'statics/assets/vue')

export default defineConfig({
  plugins: [
    vue(),

    // 🔹 Clean assets/vue sebelum build
    {
      name: 'clean-vue-assets',
      buildStart() {
        if (fs.existsSync(assetsDir)) {
          fs.rmSync(assetsDir, { recursive: true, force: true })
        }
      }
    },

    // 🔹 Move index.html ke CI view
    {
      name: 'move-index-to-ci-view',
      closeBundle() {
        const src = path.resolve(__dirname, 'statics', 'index.html')
        const dest = path.resolve(__dirname, 'backend/app/Views/spa.php')

        if (fs.existsSync(src)) {
          fs.copyFileSync(src, dest)
          fs.unlinkSync(src) // hapus index.html di root
        }
      }
    }
  ],

  resolve: {
    alias: {
      '@': path.resolve(__dirname, 'frontend'),
    },
  },

  root: 'frontend',
  publicDir: "../statics",

  server: {
    port: 5173,
    host: '0.0.0.0',
  },

  build: {
    outDir: path.resolve(__dirname, 'statics'),
    emptyOutDir: false,
    rollupOptions: {
      input: path.resolve(__dirname, 'frontend/index.html'),
      output: {
        assetFileNames: 'assets/vue/[name]-[hash][extname]',
        chunkFileNames: 'assets/vue/[name]-[hash].js',
        entryFileNames: 'assets/vue/[name]-[hash].js'
      }
    }
  }
})
