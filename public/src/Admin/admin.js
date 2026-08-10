import { $ } from "../common.js";
import { qa, qs, quillSelector } from "../constants";
import "@components/popup.scss";
import "./admin.scss";

import "./cache/Cache.js";
import "@components/accordion/accordion.js";
import "@components/date/date.js";
import "@components/adminPanel/adminPanel.js";

import "./Planning/planning.js";
import "./Settings/settings.js";
import "./Videoinstructions/videoinstructions.js";
import "./Category/Category.js";

import AdminHeader from "../components/header/header-adm.js";
import Search from "../components/search/search.js";
import adminScroll from "@components/scroll/adminScroll.js";
import Navigation from "./components/Navigation.js";

import AdminSidebar from "@src/Admin/components/AdminSidebar/AdminSidebar.js";
import Cache from "./cache/Cache.js";
import adminPanel from "@components/adminPanel/adminPanel.js";

$(document).ready(async function () {
  document.body.classList.remove("preload");

  const admin = window.location.pathname.includes("adminsc");
  if (!admin) return false;

  new Cache();
  new Search(true);
  new Navigation();
  new AdminHeader();
  new adminPanel();
  new adminScroll();
  new AdminSidebar();

  const table = $("[custom-table]").first();
  if (table) {
    const { default: Tables } = await import("../components/table/Tables.js");
    new Tables();
  }
  const quills = document[qa](quillSelector);
  if (quills) {
    const { default: QuillFactory } =
      await import("../components/quill/QuillFactory.js");
    [].forEach.call(quills, (el) => {
      new QuillFactory(el);
    });
  }

  if (window.location.pathname.includes("/adminsc")) {
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

  const dnd = $("[dnd]");
  if (dnd) {
    const { default: Dnds } = await import("@components/dnd/Dnds.js");
    new Dnds();
  }
  if (document[qs](".modal")) {
    const { default: Modal } = await import("../components/Modal/modal.js");
    new Modal();
  }

  const cardPanel = document[qs](`.card-panel`);
  if (cardPanel) {
    const { default: Card_panel } =
      await import("@components/card_panel/card_panel");
    new Card_panel();
  }

  const product = document[qs](`.item-wrap[data-model='product']`);
  if (product) {
    const { default: Product } = await import("./Product/Product.js");
    new Product();
  }

  if (document[qs](".order-edit")) {
    const { default: Order } = await import("./Order/order.js");
    new Order();
  }
  const catalogItem = document[qs](".item-wrap");
  if (catalogItem) {
    const { default: CatalogItem } =
      await import("./components/catalog-item/catalog-item.js");
    new CatalogItem(catalogItem);
  }
  const category = document[qs](`.item-wrap[data-model='category']`);
  if (category) {
    const { default: Category } = await import("./Category/Category.js");
    new Category(category);
  }
});
