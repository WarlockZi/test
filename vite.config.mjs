import {defineConfig} from 'vite';
import usePHP from 'vite-plugin-php';
// import liveReload from 'vite-plugin-live-reload'
import path from 'node:path'

export default defineConfig({
   manifest: true,
   // root: 'public',
   plugins: [
   ],
   server: {
      strictPort: true,
      hmr: {
         host: 'localhost',
      },
   },
   build: {
      // outDir: 'public/dist',
      emptyOutDir: true,
      copyPublicDir: false,

   },
   rollupOptions: {

   }

});