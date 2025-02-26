import { defineConfig } from 'vite/dist/node/index'
import { resolve } from 'path'
import liveReload from 'vite-plugin-live-reload/dist/index'

export default defineConfig({
  plugins: [
    liveReload([
      // update of php source will trigger browser reload
      __dirname + '../**/*.php',
    ]),
  ],
  server: {
    port: 3000,
    strictPort: true,
    cors: true,
    // proxy: {
    //   '/index.php': {
    //     // change the URL according to your local web server environment
    //     target: 'http://localhost/public/',
    //     changeOrigin: true,
    //     secure: false,
    //   },
    //   // include other *.php sources called from your web app
    // }
  },

  base: "",

  publicDir: './src/assets',

  build: {
    manifest: true,
    rollupOptions: {
      input: resolve(__dirname, './public/src/Main/main.js'),
      output: {
        dir: 'dist',
        entryFileNames: 'build/bundle-[hash].js',
        assetFileNames: 'build/bundle-[hash].css',
      }
    }
  }

})