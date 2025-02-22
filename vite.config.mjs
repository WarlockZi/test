import {defineConfig, loadEnv} from 'vite'
import liveReload from 'vite-plugin-live-reload'
import basicSsl from '@vitejs/plugin-basic-ssl'
import path from 'node:path'

export default defineConfig(async ({command, mode}) => {
      const env = loadEnv(mode, process.cwd())
      console.log('command - ' + command)

      const host = 'localhost'
      const port = 5173

      return {
         server: {
            cors: true,
            host: host,
            // origin: 'apo',//это чтобы admin-accordion arrow svg (assets) мог загружаться из css
            strictPort: true,
            https: true,
            port,
            hmr: {host}
         },

         define: {
            'env': env
         },
         plugins: [
            // vue(),
            basicSsl(),
            liveReload([
               // edit live reload paths according to your source code
               // __dirname + '/(app|config|views)/**/*.php',
               // __dirname + '/public/src/**/*.js',
               // __dirname + '/public/src/**/*.scss',
               __dirname + '/public/**/*.php',
               __dirname + '/app/**/*.php',
            ]),
         ],

         root: 'public/src',
         base: env.VITE_APP_ENV === 'development'
            ? ''
            : './',

         css: {
            preprocessorOptions: {
               scss: {
                  api: 'modern-compiler', // or "modern", "legacy"
               },
            },
            devSourcemap: true,
         },

         build: {
            outDir: '../../public/build',
            emptyOutDir: true,
            target: 'esnext',
            manifest: true,
            sourcemap: true,
            analyze: true,

            rollupOptions: {
               input: {
                  admin: path.resolve(__dirname, 'public/src/Admin/admin.js'),
                  main: path.resolve(__dirname, 'public/src/Main/main.js'),
               }
            }
         },

         resolve: {
            alias: {
               '@src': `${path.resolve(__dirname, 'public', 'src')}`
            }
         }
      }
   }
)
