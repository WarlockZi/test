import {defineConfig, loadEnv} from 'vite'
import liveReload from 'vite-plugin-live-reload'
import path from 'node:path'

// import {browserslistToTargets} from 'lightningcss';

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
      base: env.VITE_APP_ENV === 'development'
         ? '/public/build/'
         : '/',

      css: {
         preprocessorOptions: {
            scss: {
               api: 'modern-compiler', // or "modern", "legacy"
               importers: [
                  // ...
               ],
            },
         },
         devSourcemap: true,
         // transformer:'lightningcss',
         // targets: browserslistToTargets(['since 2022'])
      },

      build: {
         // cssMinify: 'lightningcss',
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
            // '@pic': `${path.resolve(__dirname, 'pic')}/`,
            // '@main': `${path.resolve(__dirname, 'pic','srvc','main')}/`,
            '@icons': `${path.resolve(__dirname, 'pic', 'icons')}/`,
            '@fonts': path.resolve(__dirname, 'pic', 'fonts'),
            '@ss': `${path.resolve(__dirname, 'public', 'src','font')}/`
            // vue: 'vue/dist/vue.esm-bundler.js'
         }
      }
   }
})
