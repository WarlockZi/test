import {defineConfig, loadEnv} from 'vite';
import liveReload from 'vite-plugin-live-reload';
import mkcert from 'vite-plugin-mkcert';
import path from 'node:path';
import {NodePackageImporter} from 'sass-embedded';
import {visualizer} from 'rollup-plugin-visualizer';

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

         optimizeDeps: {
            include: ['xss'] // Для лучшей производительности
         },

         build: {
            outDir: '../build',
            emptyOutDir: true,
            target: 'esnext',
            manifest: true,
            sourcemap: true,
            analyze: true,

            rollupOptions: {
               output: {
                  manualChunks: {
                     chartjs: ['chart.js'],
                     quill: ['quill'],
                     lodashes: ['lodash-es'],
                  },
               },

               external: [
                  '/storage/app/svg/search.svg',
                  '/storage/app/svg/yandex.svg',
                  '/storage/app/svg/arrowUp.svg',
                  '/storage/app/svg/view.svg',
                  '/storage/app/svg/no-view.svg',
                  '/storage/app/svg/upDown.svg',
                  '/storage/app/srvc/main/header-big.png',
                  '/storage/app/srvc/404_bg_pages.webp',
                  '/storage/app/srvc/full-logo.jpg',
                  '/storage/app/srvc/main/site-gloves.jpg',
                  '/storage/app/srvc/main/site-bootcover-824.jpg',
                  '/storage/app/srvc/main/site-syringe-gradientt.jpg',
               ],
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
            visualizer({
               open: false, // Opens the report in browser automatically
               gzipSize: true,
               brotliSize: true,
            }),
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
               {
                  '@src': `${path.resolve(__dirname, 'public', 'src')}`,
                  '@components': path.resolve(__dirname, 'public', 'src', 'components'),
                  '@srvc': path.resolve(__dirname, 'storage', 'app', 'srvc'),
                  '@svg': path.resolve(__dirname, 'storage', 'app', 'svg'),
               },
         },

         define: {
            'env': env,
         },
      };
   },
);
