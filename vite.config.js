import {defineConfig} from 'vite';
import path from 'path';

export default defineConfig({
<<<<<<< Updated upstream
=======
  base: '/',

>>>>>>> Stashed changes
  server: {
    host: 'localhost',
    port:5000,
    http: { // https => https://localhost:3000 | http => http://localhost:3000
      maxSessionMemory: 100
    }
  },
  // root: path.resolve(__dirname, './public/src'),
  build: {
<<<<<<< Updated upstream
    outDir: path.resolve(__dirname, './dist')
=======
    emptyOutDir: true,
    outDir: path.resolve(__dirname, '/dist'),
    rollupOptions: {
      output: {
        entryFileNames: `assets/[name].js`,
        chunkFileNames: `assets/[name].js`,
        assetFileNames: `assets/[name].[ext]`
      }
    },
>>>>>>> Stashed changes
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