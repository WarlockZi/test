import {defineConfig, loadEnv} from 'vite';
import liveReload from 'vite-plugin-live-reload';
import mkcert from 'vite-plugin-mkcert';
import path from 'node:path';
import {NodePackageImporter} from 'sass-embedded';
import { fileURLToPath } from 'url';

export default defineConfig(async ({command, mode}) => {
      const env = loadEnv(mode, process.cwd());
      console.log('dev - ' + env.VITE_DEV);

      const base = env.VITE_DEV
         ? './'
         : './public/build/';

      return {
         root: 'public/src',
         base,

         server: {
            https: true,
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
                  admin: path.resolve(__dirname, 'public/src/Admin/admin.js'),
                  main: path.resolve(__dirname, 'public/src/Main/main.js'),
               },
            },
         },
         plugins: [
            mkcert(),
            liveReload([
               // __dirname + '/(app|config|views)/**/*.php',
               __dirname + '/public/**/*.php',
               __dirname + '/app/**/*.php',
               __dirname + '/.env',
            ]),
         ],


         css: {
            preprocessorOptions: {
               scss: {
                  api: 'modern-compiler', // or "modern", "legacy"
                  importers: [new NodePackageImporter()],
               },
            },
            devSourcemap: true,
         },

         resolve: {
            alias:
            //    [
            //       { find: '@src', replacement: fileURLToPath(new URL('./public/src', import.meta.url)) },
            //       { find: '@components', replacement: fileURLToPath(new URL('./public/src/components', import.meta.url)) },
            // //    {
            // //       find:'@src',
            // //       // replace:path.resolve(__dirname, 'public','src'),
            // //       replace:fileURLToPath(new URL( path.resolve(__dirname,'public/src', import.meta.url))),
            // //    },
            // //    {
            // //       find:'@components',
            // //       replace:fileURLToPath(new URL(  path.resolve(__dirname,'public/src/components', import.meta.url))),
            // //    },
            // ],
               {
                  '@src': `${path.resolve(__dirname, 'public', 'src')}`,
                  '@components': `${path.resolve(__dirname, 'public', 'src', 'components')}`,
                  '@srvc': path.resolve(__dirname, 'storage', 'app', 'srvc'),
               },
         },

         define: {
            'env': env,
         },
      };
   },
);
