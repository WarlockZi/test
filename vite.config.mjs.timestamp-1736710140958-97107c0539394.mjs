// vite.config.mjs
import { defineConfig, loadEnv } from "file:///D:/OSPanel/domains/vi-prod/node_modules/vite/dist/node/index.js";
import liveReload from "file:///D:/OSPanel/domains/vi-prod/node_modules/vite-plugin-live-reload/dist/index.js";
import path from "node:path";
var __vite_injected_original_dirname = "D:\\OSPanel\\domains\\vi-prod";
var vite_config_default = defineConfig(async ({ command, mode }) => {
  const env = loadEnv(mode, process.cwd());
  console.log(env);
  const rootCssPath = path.resolve(__vite_injected_original_dirname, "public", "src");
  return {
    // define: {
    //    'env': env
    // },
    plugins: [
      // vue(),
      // basicSsl(),
      liveReload([
        // edit live reload paths according to your source code
        // __dirname + '/(app|config|views)/**/*.php',
        __vite_injected_original_dirname + "/public/src/**/*.js",
        __vite_injected_original_dirname + "/public/*.php"
      ])
      // splitVendorChunkPlugin(),
    ],
    root: "public/src",
    base: env.VITE_APP_ENV === "development" ? "/public/build/" : "./",
    css: {
      preprocessorOptions: {
        scss: {
          // additionalData: `@use "@src/_consts";`,
          api: "modern-compiler",
          // or "modern", "legacy"
          importers: []
        }
      },
      devSourcemap: true
    },
    build: {
      outDir: "../../public/build",
      emptyOutDir: true,
      target: "esnext",
      manifest: true,
      sourcemap: true,
      analyze: true,
      rollupOptions: {
        input: {
          admin: path.resolve(__vite_injected_original_dirname, "public/src/Admin/admin.js"),
          // auth: path.resolve(__dirname, 'public/src/Auth/auth.js'),
          main: path.resolve(__vite_injected_original_dirname, "public/src/Main/main.js")
        }
      }
    },
    server: {
      origin: "https://vi-prod:5133",
      //это чтобы admin-accordion arrow svg (assets) мог загружаться из css
      strictPort: true,
      // https: true,
      port: 5133
      // watch: {
      //    usePolling: true,
      // }
    },
    // required for in-browser template compilation
    // https://vuejs.org/guide/scaling-up/tooling.html#note-on-in-browser-template-compilation
    resolve: {
      alias: {
        // '@pic': `${path.resolve(__dirname, 'pic')}/`,
        // '@main': `${path.resolve(__dirname, 'pic','srvc','main')}/`,
        "@icons": `${path.resolve(__vite_injected_original_dirname, "pic", "icons")}/`,
        "@fonts": path.resolve(__vite_injected_original_dirname, "pic", "fonts"),
        "@ss": `${path.resolve(__vite_injected_original_dirname, "public", "src", "font")}/`,
        "@src": `${path.resolve(__vite_injected_original_dirname, "public", "src")}`
        // vue: 'vue/dist/vue.esm-bundler.js'
      }
    }
  };
});
export {
  vite_config_default as default
};
//# sourceMappingURL=data:application/json;base64,ewogICJ2ZXJzaW9uIjogMywKICAic291cmNlcyI6IFsidml0ZS5jb25maWcubWpzIl0sCiAgInNvdXJjZXNDb250ZW50IjogWyJjb25zdCBfX3ZpdGVfaW5qZWN0ZWRfb3JpZ2luYWxfZGlybmFtZSA9IFwiRDpcXFxcT1NQYW5lbFxcXFxkb21haW5zXFxcXHZpLXByb2RcIjtjb25zdCBfX3ZpdGVfaW5qZWN0ZWRfb3JpZ2luYWxfZmlsZW5hbWUgPSBcIkQ6XFxcXE9TUGFuZWxcXFxcZG9tYWluc1xcXFx2aS1wcm9kXFxcXHZpdGUuY29uZmlnLm1qc1wiO2NvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9pbXBvcnRfbWV0YV91cmwgPSBcImZpbGU6Ly8vRDovT1NQYW5lbC9kb21haW5zL3ZpLXByb2Qvdml0ZS5jb25maWcubWpzXCI7aW1wb3J0IHtkZWZpbmVDb25maWcsIGxvYWRFbnZ9IGZyb20gJ3ZpdGUnXG5pbXBvcnQgbGl2ZVJlbG9hZCBmcm9tICd2aXRlLXBsdWdpbi1saXZlLXJlbG9hZCdcbmltcG9ydCBwYXRoIGZyb20gJ25vZGU6cGF0aCdcblxuZXhwb3J0IGRlZmF1bHQgZGVmaW5lQ29uZmlnKGFzeW5jICh7Y29tbWFuZCwgbW9kZX0pID0+IHtcbiAgIGNvbnN0IGVudiA9IGxvYWRFbnYobW9kZSwgcHJvY2Vzcy5jd2QoKSlcbiAgIGNvbnNvbGUubG9nKGVudilcbiAgIGNvbnN0IHJvb3RDc3NQYXRoID0gcGF0aC5yZXNvbHZlKF9fZGlybmFtZSwgJ3B1YmxpYycsJ3NyYycpXG4gICByZXR1cm4ge1xuXG4gICAgICAvLyBkZWZpbmU6IHtcbiAgICAgIC8vICAgICdlbnYnOiBlbnZcbiAgICAgIC8vIH0sXG4gICAgICBwbHVnaW5zOiBbXG4gICAgICAgICAvLyB2dWUoKSxcbiAgICAgICAgIC8vIGJhc2ljU3NsKCksXG4gICAgICAgICBsaXZlUmVsb2FkKFtcbiAgICAgICAgICAgIC8vIGVkaXQgbGl2ZSByZWxvYWQgcGF0aHMgYWNjb3JkaW5nIHRvIHlvdXIgc291cmNlIGNvZGVcbiAgICAgICAgICAgIC8vIF9fZGlybmFtZSArICcvKGFwcHxjb25maWd8dmlld3MpLyoqLyoucGhwJyxcbiAgICAgICAgICAgIF9fZGlybmFtZSArICcvcHVibGljL3NyYy8qKi8qLmpzJyxcbiAgICAgICAgICAgIF9fZGlybmFtZSArICcvcHVibGljLyoucGhwJyxcbiAgICAgICAgIF0pLFxuICAgICAgICAgLy8gc3BsaXRWZW5kb3JDaHVua1BsdWdpbigpLFxuICAgICAgXSxcblxuICAgICAgcm9vdDogJ3B1YmxpYy9zcmMnLFxuICAgICAgYmFzZTogZW52LlZJVEVfQVBQX0VOViA9PT0gJ2RldmVsb3BtZW50J1xuICAgICAgICAgPyAnL3B1YmxpYy9idWlsZC8nXG4gICAgICAgICA6ICcuLycsXG5cbiAgICAgIGNzczoge1xuICAgICAgICAgcHJlcHJvY2Vzc29yT3B0aW9uczoge1xuICAgICAgICAgICAgc2Nzczoge1xuICAgICAgICAgICAgICAgLy8gYWRkaXRpb25hbERhdGE6IGBAdXNlIFwiQHNyYy9fY29uc3RzXCI7YCxcbiAgICAgICAgICAgICAgIGFwaTogJ21vZGVybi1jb21waWxlcicsIC8vIG9yIFwibW9kZXJuXCIsIFwibGVnYWN5XCJcbiAgICAgICAgICAgICAgIGltcG9ydGVyczogW1xuICAgICAgICAgICAgICAgXSxcbiAgICAgICAgICAgIH0sXG4gICAgICAgICB9LFxuICAgICAgICAgZGV2U291cmNlbWFwOiB0cnVlLFxuICAgICAgfSxcblxuICAgICAgYnVpbGQ6IHtcbiAgICAgICAgIG91dERpcjogJy4uLy4uL3B1YmxpYy9idWlsZCcsXG4gICAgICAgICBlbXB0eU91dERpcjogdHJ1ZSxcbiAgICAgICAgIHRhcmdldDogJ2VzbmV4dCcsXG4gICAgICAgICBtYW5pZmVzdDogdHJ1ZSxcbiAgICAgICAgIHNvdXJjZW1hcDogdHJ1ZSxcbiAgICAgICAgIGFuYWx5emU6dHJ1ZSxcblxuICAgICAgICAgcm9sbHVwT3B0aW9uczoge1xuICAgICAgICAgICAgaW5wdXQ6IHtcbiAgICAgICAgICAgICAgIGFkbWluOiBwYXRoLnJlc29sdmUoX19kaXJuYW1lLCAncHVibGljL3NyYy9BZG1pbi9hZG1pbi5qcycpLFxuICAgICAgICAgICAgICAgLy8gYXV0aDogcGF0aC5yZXNvbHZlKF9fZGlybmFtZSwgJ3B1YmxpYy9zcmMvQXV0aC9hdXRoLmpzJyksXG4gICAgICAgICAgICAgICBtYWluOiBwYXRoLnJlc29sdmUoX19kaXJuYW1lLCAncHVibGljL3NyYy9NYWluL21haW4uanMnKSxcbiAgICAgICAgICAgIH1cbiAgICAgICAgIH1cbiAgICAgIH0sXG5cblxuICAgICAgc2VydmVyOiB7XG4gICAgICAgICBvcmlnaW46ICdodHRwczovL3ZpLXByb2Q6NTEzMycsLy9cdTA0NERcdTA0NDJcdTA0M0UgXHUwNDQ3XHUwNDQyXHUwNDNFXHUwNDMxXHUwNDRCIGFkbWluLWFjY29yZGlvbiBhcnJvdyBzdmcgKGFzc2V0cykgXHUwNDNDXHUwNDNFXHUwNDMzIFx1MDQzN1x1MDQzMFx1MDQzM1x1MDQ0MFx1MDQ0M1x1MDQzNlx1MDQzMFx1MDQ0Mlx1MDQ0Q1x1MDQ0MVx1MDQ0RiBcdTA0MzhcdTA0MzcgY3NzXG4gICAgICAgICBzdHJpY3RQb3J0OiB0cnVlLFxuICAgICAgICAgLy8gaHR0cHM6IHRydWUsXG4gICAgICAgICBwb3J0OiA1MTMzLFxuICAgICAgICAgLy8gd2F0Y2g6IHtcbiAgICAgICAgIC8vICAgIHVzZVBvbGxpbmc6IHRydWUsXG4gICAgICAgICAvLyB9XG4gICAgICB9LFxuXG4gICAgICAvLyByZXF1aXJlZCBmb3IgaW4tYnJvd3NlciB0ZW1wbGF0ZSBjb21waWxhdGlvblxuICAgICAgLy8gaHR0cHM6Ly92dWVqcy5vcmcvZ3VpZGUvc2NhbGluZy11cC90b29saW5nLmh0bWwjbm90ZS1vbi1pbi1icm93c2VyLXRlbXBsYXRlLWNvbXBpbGF0aW9uXG4gICAgICByZXNvbHZlOiB7XG4gICAgICAgICBhbGlhczoge1xuICAgICAgICAgICAgLy8gJ0BwaWMnOiBgJHtwYXRoLnJlc29sdmUoX19kaXJuYW1lLCAncGljJyl9L2AsXG4gICAgICAgICAgICAvLyAnQG1haW4nOiBgJHtwYXRoLnJlc29sdmUoX19kaXJuYW1lLCAncGljJywnc3J2YycsJ21haW4nKX0vYCxcbiAgICAgICAgICAgICdAaWNvbnMnOiBgJHtwYXRoLnJlc29sdmUoX19kaXJuYW1lLCAncGljJywgJ2ljb25zJyl9L2AsXG4gICAgICAgICAgICAnQGZvbnRzJzogcGF0aC5yZXNvbHZlKF9fZGlybmFtZSwgJ3BpYycsICdmb250cycpLFxuICAgICAgICAgICAgJ0Bzcyc6IGAke3BhdGgucmVzb2x2ZShfX2Rpcm5hbWUsICdwdWJsaWMnLCAnc3JjJywgJ2ZvbnQnKX0vYCxcbiAgICAgICAgICAgICdAc3JjJzogYCR7cGF0aC5yZXNvbHZlKF9fZGlybmFtZSwgJ3B1YmxpYycsICdzcmMnKX1gXG4gICAgICAgICAgICAvLyB2dWU6ICd2dWUvZGlzdC92dWUuZXNtLWJ1bmRsZXIuanMnXG4gICAgICAgICB9XG4gICAgICB9XG4gICB9XG59KVxuIl0sCiAgIm1hcHBpbmdzIjogIjtBQUEwUSxTQUFRLGNBQWMsZUFBYztBQUM5UyxPQUFPLGdCQUFnQjtBQUN2QixPQUFPLFVBQVU7QUFGakIsSUFBTSxtQ0FBbUM7QUFJekMsSUFBTyxzQkFBUSxhQUFhLE9BQU8sRUFBQyxTQUFTLEtBQUksTUFBTTtBQUNwRCxRQUFNLE1BQU0sUUFBUSxNQUFNLFFBQVEsSUFBSSxDQUFDO0FBQ3ZDLFVBQVEsSUFBSSxHQUFHO0FBQ2YsUUFBTSxjQUFjLEtBQUssUUFBUSxrQ0FBVyxVQUFTLEtBQUs7QUFDMUQsU0FBTztBQUFBO0FBQUE7QUFBQTtBQUFBLElBS0osU0FBUztBQUFBO0FBQUE7QUFBQSxNQUdOLFdBQVc7QUFBQTtBQUFBO0FBQUEsUUFHUixtQ0FBWTtBQUFBLFFBQ1osbUNBQVk7QUFBQSxNQUNmLENBQUM7QUFBQTtBQUFBLElBRUo7QUFBQSxJQUVBLE1BQU07QUFBQSxJQUNOLE1BQU0sSUFBSSxpQkFBaUIsZ0JBQ3RCLG1CQUNBO0FBQUEsSUFFTCxLQUFLO0FBQUEsTUFDRixxQkFBcUI7QUFBQSxRQUNsQixNQUFNO0FBQUE7QUFBQSxVQUVILEtBQUs7QUFBQTtBQUFBLFVBQ0wsV0FBVyxDQUNYO0FBQUEsUUFDSDtBQUFBLE1BQ0g7QUFBQSxNQUNBLGNBQWM7QUFBQSxJQUNqQjtBQUFBLElBRUEsT0FBTztBQUFBLE1BQ0osUUFBUTtBQUFBLE1BQ1IsYUFBYTtBQUFBLE1BQ2IsUUFBUTtBQUFBLE1BQ1IsVUFBVTtBQUFBLE1BQ1YsV0FBVztBQUFBLE1BQ1gsU0FBUTtBQUFBLE1BRVIsZUFBZTtBQUFBLFFBQ1osT0FBTztBQUFBLFVBQ0osT0FBTyxLQUFLLFFBQVEsa0NBQVcsMkJBQTJCO0FBQUE7QUFBQSxVQUUxRCxNQUFNLEtBQUssUUFBUSxrQ0FBVyx5QkFBeUI7QUFBQSxRQUMxRDtBQUFBLE1BQ0g7QUFBQSxJQUNIO0FBQUEsSUFHQSxRQUFRO0FBQUEsTUFDTCxRQUFRO0FBQUE7QUFBQSxNQUNSLFlBQVk7QUFBQTtBQUFBLE1BRVosTUFBTTtBQUFBO0FBQUE7QUFBQTtBQUFBLElBSVQ7QUFBQTtBQUFBO0FBQUEsSUFJQSxTQUFTO0FBQUEsTUFDTixPQUFPO0FBQUE7QUFBQTtBQUFBLFFBR0osVUFBVSxHQUFHLEtBQUssUUFBUSxrQ0FBVyxPQUFPLE9BQU8sQ0FBQztBQUFBLFFBQ3BELFVBQVUsS0FBSyxRQUFRLGtDQUFXLE9BQU8sT0FBTztBQUFBLFFBQ2hELE9BQU8sR0FBRyxLQUFLLFFBQVEsa0NBQVcsVUFBVSxPQUFPLE1BQU0sQ0FBQztBQUFBLFFBQzFELFFBQVEsR0FBRyxLQUFLLFFBQVEsa0NBQVcsVUFBVSxLQUFLLENBQUM7QUFBQTtBQUFBLE1BRXREO0FBQUEsSUFDSDtBQUFBLEVBQ0g7QUFDSCxDQUFDOyIsCiAgIm5hbWVzIjogW10KfQo=
