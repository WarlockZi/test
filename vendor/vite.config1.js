import {defineConfig, splitVendorChunkPlugin} from 'vite/dist/node/index';
import {resolve} from 'path';
import path from 'node:path';
import liveReload from 'vite-plugin-live-reload/dist/index'


const port = 3009
export default defineConfig({
  // root: resolve(__dirname, './public'),
  base: '',
  // base: process..env.VITE_APP_ENV === 'development'
  //   ? '/'
  //   : '/',

  host: 'localhost',
  server: {
    hmr: {
      host: 'localhost',
      // clientPort: 80,
      // port: port,
      protocol: 'ws',
    },
    strictPort: true,
    port: port,

  },


  build: {
    // emit manifest so PHP can find the hashed files
    manifest: true,
    minify: true,
    emptyOutDir: true,
    outDir: resolve(__dirname, './public/build'),

    rollupOptions: {
      input: path.resolve(__dirname, 'public/src/Main/main.js'),
    }
  },

  resolve: {
    alias: {
      '@components': resolve(__dirname, './public/src/components'),
    },
  },

  plugins: [{


    // splitVendorChunkPlugin(),
    // liveReload([
    //   // edit live reload paths according to your source code
    //   // for example:
    //   __dirname + '/(app|config|views)/**/*.php',
    //   // using this for our example:
    //   __dirname + '/public/*.php',
    // ]),

    // {
    //   name: 'php',
    //   handleHotUpdate({ file, server }) {
    //     if (file.endsWith('.php')) {
    //       server.ws.send({ type: 'full-reload' });
    //     }
    //   },
    // },
  }
  ]

});