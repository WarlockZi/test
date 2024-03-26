import {defineConfig} from 'vite';
import path from 'path';
import {fileURLToPath, URL} from "url";

export default defineConfig({

  server: {
    // cors:{
    //   "origin": "*",
    // },
    proxy: {
      '/vi-production': {
        target: 'ws://localhost:5173',
        ws: true,
      },
    },
    host: 'localhost',
    port: 5173,
    http: {
      maxSessionMemory: 100
    },
    publcDir: '/dd'
    // origin: 'http://127.0.0.1:5000'

  },
  // // root: path.resolve(__dirname, './public/src'),
  build: {
    outDir: path.resolve(__dirname, '/public/src'),
    manifest: true,
  },
  //
  //
  rollupInputOptions: {
    input: path.resolve(__dirname, 'public/src/Admin/admin.js'),
    // admin: path.resolve(__dirname, './public/src/Admin/admin.js')
  },
  // resolve: {
  //   alias:
  //     [
  //       // {'@': path.resolve(__dirname, './public/src')},
  //       {'@components': path.resolve(__dirname, './public/src/components')},
  //     ]
  // },
  // plugins: []
});