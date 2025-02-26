import { defineConfig } from 'vite/dist/node/index'
import { resolve } from 'path'
import mkcert from 'vite-plugin-mkcert/dist'
import liveReload from 'vite-plugin-live-reload/dist/index'

export default defineConfig({
  plugins: [
    mkcert()
    // liveReload([
    //   // update of php source will trigger browser reload
    //   __dirname + '/**/*.php',
    // ]),
    // HtmlRewriter()
  ],

  server: {
    host:'vi-production',
    port:3000,
    https:true,
    cors: false,

    hmr: {
      host: "vi-production",
      port: 3000,
      protocol: "wss",
    },
    // cors:true,
    // cors: {
    //   origin: false
    // },
    // proxy: {
    //   // ws:true,
    //   "^/$": {
    //     target: "http://vi-production:5174",
    //
    //     // Change the "origin" header to the target host.
    //     changeOrigin: true,
    //
    //     // Serve this path under the new target host.
    //     rewrite: () => "/vi-production/",
    //   },
    // },
    "/static": {
      target: "http://localhost:5174/public/src/",
      changeOrigin: true,
    },

  },

  base: "./",
  publicDir: './src/assets',
  build: {
    sourcemap: true,
    manifest: true,
    rollupOptions: {
      input: resolve(__dirname, 'public/src/Main/admin.js'),
      output: {
        dir: 'dist',
        entryFileNames: 'dist/bundle-[hash].js',
        assetFileNames: 'dist/bundle-[hash].css',
      }
    }
  }

})