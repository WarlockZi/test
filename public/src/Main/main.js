import "../Pages/main/main.scss";
import "./layout/index.js";
// import { $ } from "@src/common.js";

import We_use_cookie_notification from "@src/Modules/main/we_use_cookie_notification/we_use_cookie_notification.js";
import { qs } from "@src/constants.js";

document.addEventListener("DOMContentLoaded", async function () {
  const admin = window.location.pathname.includes("adminsc");
  if (admin) return false;

  document.body.classList.remove("preload"); //to prevent initial transitions

  await We_use_cookie_notification.show_use_cookie_notification();

  await loadPageScripts();

  async function loadPageScripts() {
    const moduleName = document[qs](`[data-jsmodule]`)?.dataset?.jsmodule;
    if (!moduleName) return false;
    try {
      const { default: ModuleClass } = await import(
        `@src/Pages/${moduleName}/${moduleName}.js`
      );
      new ModuleClass();
    } catch (error) {
      console.error(`Ошибка загрузки модуля ${moduleName}:`, error);
    }
  }
});
