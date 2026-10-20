import { defineConfig, loadEnv } from "vite";
import liveReload from "vite-plugin-live-reload";
import mkcert from "vite-plugin-mkcert";
import path from "node:path";
import { NodePackageImporter } from "sass-embedded";
import { randomUUID } from "node:crypto";
import process from "node:process";

let styleNonce = "";
export default defineConfig(async ({ command, mode }) => {
  const env = loadEnv(mode, process.cwd());

  // Generate nonce only once
  if (!styleNonce) {
    styleNonce = Buffer.from(randomUUID()).toString("base64");
  }

  const outputDir = env.VITE_DEV ? "./" : "/public/build/"; // nb no dot before slash for production

  return {
    root: "public/src",
    base: outputDir,

    server: {
      https: true,
      cors: true,
      strictPort: false,
      port: env.VITE_PORT,
    },

    optimizeDeps: {
      include: ["xss"], // Для лучшей производительности
    },
    build: {
      outDir: "../build",
      emptyOutDir: true,
      target: "esnext",
      manifest: true,
      sourcemap: true,

      rollupOptions: {
        treeshake: true,
        input: {
          auth: path.resolve(__dirname, "public/src/Auth/auth.js"),
          admin: path.resolve(__dirname, "public/src/Admin/admin.js"),
          main: path.resolve(__dirname, "public/src/Main/main.js"),
        },
        output: {
          manualChunks(id) {
            if (!id.includes("node_modules")) return undefined;

            // Тяжелые библиотеки → отдельные чанки
            if (id.includes("/chart.js/")) return "chartjs";
            if (id.includes("/quill/")) return "quill";
            if (id.includes("/lodash-es/")) return "lodash-es";

            // Всё остальное → ОДИН общий vendor-чанк
            return "vendor";
          },
        },
      },
    },

    plugins: [
      {
        name: "add-nonce-to-styles",
        transformIndexHtml(html, { command }) {
          if (command === "serve") {
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
              `default-src 'self'; style-src 'self' 'nonce-${styleNonce}'; script-src 'self'`,
            );
            next();
          });
        },
      },

      mkcert(),
      liveReload([
        __dirname + "/public/**/*.php",
        __dirname + "/app/**/*.php",
        __dirname + "/.env",
      ]),
    ],
    css: {
      preprocessorOptions: {
        scss: {
          api: "modern-compiler", // or "modern", "legacy"
          importers: [new NodePackageImporter()],
        },
      },
      devSourcemap: true,
    },
    resolve: {
      alias: {
        "@src": path.resolve(__dirname, "public", "src"),
        "@components": path.resolve(__dirname, "public", "src", "components"),
        "@pages": path.resolve(__dirname, "public", "src", "Pages"),
        "@modules": path.resolve(__dirname, "public", "src", "Modules"),
      },
    },
  };
});
