import { $ } from "../common.js";
import "./layout/index.js";
import "./admin.scss";
import "@components/date/date.js";
import "./Category/Category.js";

// import MyQuills from "@components/quill/MyQuills.js";
import MyCardPanels from "@src/Modules/admin/card_panel/MyCardPanels.js";
import MyTables from "@components/table/MyTables.js";
// import MyDnds from "@src/Modules/share/my_dnds/my_dnds.js";

$(document).ready(async function () {
  document.body.classList.remove("preload");

  const admin = window.location.pathname.includes("adminsc");
  if (!admin) return false;

  new MyCardPanels();
  new MyTables();
  // new MyDnds();
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

  // if (document[qs](".orders-edit")) {
  const { default: Order } = await import("@src/Admin/Pages/Order/order.js");
  //   new orders();
  // }
});
