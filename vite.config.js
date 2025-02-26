import {defineConfig} from 'vite';
import path from 'path';
import htmlPurge from 'vite-plugin-html-purgecss'

export default defineConfig({
  base: './',

  server: {
    https: false,
    cors: false,
    hmr: {
      host: 'localhost'
    },
    host: 'localhost',
    port: 5000,
    http: { // https => https://localhost:3000 | http => http://localhost:3000
      maxSessionMemory: 100
    }
  },

  build: {
    emptyOutDir: true,
    outDir: path.resolve(__dirname, './dist'),
    rollupOptions: {
      output: {
        entryFileNames: `assets/[name].js`,
        chunkFileNames: `assets/[name].js`,
        assetFileNames: `assets/[name].[ext]`
      }
    },
  },

  resolve: {
    alias: {
      '@components': path.resolve(__dirname, './public/src/components'),
    },
  },

  plugins: [
    htmlPurge(),
  ]
});