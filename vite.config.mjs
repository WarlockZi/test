import {defineConfig, loadEnv} from 'vite'
// import vue from '@vitejs/plugin-vue'
import liveReload from 'vite-plugin-live-reload'
import path from 'node:path'

export default defineConfig(async ({command, mode}) => {
   const env = loadEnv(mode, process.cwd())
   console.log(env.VITE_APP_ENV)
   return {
      plugins: [
         // vue(),
         liveReload([
            // edit live reload paths according to your source code
            __dirname + '/(app|config|views)/**/*.php',
            // using this for our example:
            __dirname + '/public/*.php',
         ]),
         // splitVendorChunkPlugin(),
      ],

      root: 'public/src',
      base: env.VITE_APP_ENV === 'developmenst'
         ? '/'
         : '/public/build/',

      build: {
         // output dir for production build
         outDir: '../../public/build',
         emptyOutDir: true,

         // emit manifest so PHP can find the hashed files
         manifest: true,

         // our entry
         rollupOptions: {
            input: {
               admin: path.resolve(__dirname, 'public/src/Admin/admin.js'),
               main: path.resolve(__dirname, 'public/src/Main/main.js'),
               product: path.resolve(__dirname, 'public/src/Product/Product.js'),
            }
         }
      },

      server: {
         // we need a strict port to match on PHP side
         // change freely, but update on PHP to match the same port
         // tip: choose a different port per project to run them at the same time
         strictPort: true,
         port: 5133
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
