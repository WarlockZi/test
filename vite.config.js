import {defineConfig} from 'vite';
import {resolve} from 'path';

export default defineConfig({
  root: resolve(__dirname, './public/src'),
  server: {
    host: 'localhost',
    port:4000,
    http: { // https => https://localhost:3000 | http => http://localhost:3000
      maxSessionMemory: 100
    }
  },
  // root: path.resolve(__dirname, './public/src'),
  build: {
    outDir: resolve(__dirname, './public/build')
  },
  resolve: {
    alias: {
      // '@': path.resolve(__dirname, './src'),
      // '@assets': path.resolve(__dirname, './src/assets'),
      '@components': resolve(__dirname, './public/src/components'),
    },
  },
  plugins: []
});