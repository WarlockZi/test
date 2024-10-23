import {defineConfig, loadEnv} from 'vite'
// import vue from '@vitejs/plugin-vue'
import liveReload from 'vite-plugin-live-reload'
import path from 'node:path'

export default defineConfig(async ({command, mode}) => {
   const env = loadEnv(mode, process.cwd())
   console.log(env)

   return {
      define: {
         'env': env
      },
      plugins: [
         // vue(),
         // basicSsl(),
         liveReload([
            // edit live reload paths according to your source code
            // __dirname + '/(app|config|views)/**/*.php',
            __dirname + '/public/src/**/*.js',
            // using this for our example:
            __dirname + '/public/*.php',
         ]),
         // splitVendorChunkPlugin(),
      ],

      root: 'public/src',
      base: env.VITE_APP_ENV !== 'development'
         ? '/'
         : '/public/build/',

      css: {
         devSourcemap: true,
      },

      build: {
         // output dir for production build
         outDir: '../../public/build',
         emptyOutDir: true,
         target: 'esnext',

         // emit manifest so PHP can find the hashed files
         manifest: true,
         // sourcemap: true,

         // our entry
         rollupOptions: {
            input: {
               admin: path.resolve(__dirname, 'public/src/Admin/admin.js'),
               auth: path.resolve(__dirname, 'public/src/Auth/auth.js'),
               main: path.resolve(__dirname, 'public/src/Main/main.js'),
               // product: path.resolve(__dirname, 'public/src/Product/Product.js'),
            }
         }
      },


      server: {
         // we need a strict port to match on PHP side
         // change freely, but update on PHP to match the same port
         // tip: choose a different port per project to run them at the same time
         origin: 'https://vi-prod:5133',//это чтобы admin-accordion arrow svg (assets) мог загружаться из css
         strictPort: true,
         // https: true,
         port: 5133,
         // watch: {
         //    usePolling: true,
         // }
      },

      // required for in-browser template compilation
      // https://vuejs.org/guide/scaling-up/tooling.html#note-on-in-browser-template-compilation
      resolve: {
         alias: {
            // vue: 'vue/dist/vue.esm-bundler.js'
         }
      }
   }
})
