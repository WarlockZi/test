import {defineConfig, loadEnv} from 'vite';
import liveReload from 'vite-plugin-live-reload';
import mkcert from 'vite-plugin-mkcert';
import path from 'node:path';
import {NodePackageImporter} from 'sass-embedded';
import * as bcrypt from "crypto";

let styleNonce = '';
export default defineConfig(async ({command, mode}) => {
      const env = loadEnv(mode, process.cwd());

      // Generate nonce only once
      if (!styleNonce) {
         styleNonce = Buffer.from(bcrypt.randomUUID()).toString('base64');
      }

      const base = env.VITE_DEV
         ? './'
         : '/public/build/';// nb no dot before slash for production

      return {
         root: 'public/src',
         base,

         server: {
            https: true,
            cors: true,
            strictPort: false,
            port: env.VITE_PORT,
         },

         optimizeDeps: {
            include: ['xss'], // Для лучшей производительности
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
            // {
            //    name: 'svg-nonce',
            //    transform(src, id) {
            //       console.log(styleNonce);
            //       if (id.endsWith('.svg')) {
            //          const nonce = nonce;
            //          // const nonce = generateNonce() // ваша функция генерации nonce
            //          return src.replace('<svg', `<svg nonce="${nonce}"`);
            //       }
            //    },
            // },

            {
               name: 'add-nonce-to-styles',
               transformIndexHtml(html, {command}) {
                  if (command === 'serve') { // Only in dev mode
                     // console.log('trns html', command);
                     return html.replace(
                        /(<style[^>]*)(>)/g,
                        `$1 nonce="${styleNonce}"$2`,
                     );
                  }
                  return html;
               },
               configureServer(server) {
                  server.middlewares.use((req, res, next) => {
                     res.setHeader(
                        "Content-Security-Policy",
                        `style-src 'self' 'nonce-${styleNonce}'`,
                     );
                     next();
                  });
               },
               // transform(code, id) {
               //    if (command === 'serve' && id.endsWith('.scss')) {
               //       console.log(',,,', command);
               //       return {
               //          code: code.replace(
               //             /<style[^>]*>/,
               //             `<style nonce="${styleNonce}">`,
               //          ),
               //          map: null,
               //       };
               //    }
               // },
            },

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
               {
                  path: 'path-browserify', // for path externalized error fix
                  '@src': path.resolve(__dirname, 'public', 'src'),
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
