import {defineConfig, loadEnv} from 'vite'
import liveReload from 'vite-plugin-live-reload'
import basicSsl from '@vitejs/plugin-basic-ssl'
import path from 'node:path'

export default defineConfig(async ({command, mode}) => {
      const env = loadEnv(mode, process.cwd())
      console.log('dev - ' + !env.VITE_DEV)

      const host = env.VITE_HOST

      return {
         root: 'public/src',
         base: env.VITE_DEV
            ? '/'//for vite_dev false
            : '/',

         server: {
            cors: true,
            strictPort: true,
            port: env.VITE_PORT,
         },

         build: {
            outDir: '../build',
            emptyOutDir: true,
            target: 'esnext',
            manifest: true,
            sourcemap: true,
            analyze: true,

            rollupOptions: {
               input: {
                  auth: path.resolve(__dirname, 'public/src/Auth/auth.js'),
                  main: path.resolve(__dirname, 'public/src/Main/main.js'),
               }
            }
         },
         plugins: [
            basicSsl(),
            liveReload([
               // __dirname + '/(app|config|views)/**/*.php',
               __dirname + '/public/**/*.php',
               __dirname + '/app/**/*.php',
            ]),
         ],


         css: {
            preprocessorOptions: {
               scss: {
                  api: 'modern-compiler', // or "modern", "legacy"
               },
            },
            devSourcemap: true,
         },

         resolve: {
            alias: {
               '@src': `${path.resolve(__dirname, 'public', 'src')}`
            }
         },

         define: {
            'env': env
         },
      }
   }
)
