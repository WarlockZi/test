import {defineConfig} from 'vite';
import path from 'path';

export default defineConfig({
  server: {
    host: 'localhost',
    port:5000,
    http: { // https => https://localhost:3000 | http => http://localhost:3000
      maxSessionMemory: 100
    }
  },
  // root: path.resolve(__dirname, './public/src'),
  build: {
    outDir: path.resolve(__dirname, './dist')
  },
  resolve: {
    alias: {
      // '@': path.resolve(__dirname, './src'),
      // '@assets': path.resolve(__dirname, './src/assets'),
      '@components': path.resolve(__dirname, './public/src/components'),
    },
  },
  plugins: []
});