import { $ } from "../common.js";
import "./layout/index.js";
import "./admin.scss";
import "@components/date/date.js";
import "./Category/Category.js";
import "./layout/bottom-panel/bottom-panel.css";

import MyCardPanels from "@src/Modules/admin/card_panel/MyCardPanels.js";
import MyTables from "@components/table/MyTables.js";
import BottomPanel from "@src/Admin/layout/bottom-panel/bottom-panel.js";

$(document).ready(async function () {
  document.body.classList.remove("preload");

  const admin = window.location.pathname.includes("adminsc");
  if (!admin) return false;

  new MyCardPanels();
  new MyTables();
  new BottomPanel();
  loadPageScripts();

  function loadPageScripts() {
    const modules = import.meta.glob("@src/Admin/Pages/**/*.js", {
      eager: true,
    });

    const moduleName = $(`[data-jsmodule]`).first()?.dataset?.jsmodule;

    const modulePath = `/Admin/Pages/${moduleName}/${moduleName}.js`;
    const moduleData = modules[modulePath];

    if (moduleData) {
      const { default: module } = moduleData;
      new module();
    } else {
      console.warn(`Модуль не найден: ${modulePath}`);
    }
  }
});
