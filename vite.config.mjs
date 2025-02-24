import {defineConfig, loadEnv} from 'vite'
import liveReload from 'vite-plugin-live-reload'
import basicSsl from '@vitejs/plugin-basic-ssl'
import path from 'node:path'

export default defineConfig(async ({command, mode}) => {
      const env = loadEnv(mode, process.cwd())
      console.log('command - ' + command)

      const host = env.VITE_HOST ?? 'localhost'

      return {
         root: 'public/src',
         base: env.VITE_DEV
            ? ''
            : './build',

         server: {
            cors: true,
            host: host,
            strictPort: true,
            https: true,
            port: env.VITE_PORT,
            hmr: {host}
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
                  admin: path.resolve(__dirname, 'public/src/Admin/admin.js'),
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
