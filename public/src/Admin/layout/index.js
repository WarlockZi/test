import lazyLoad from "@src/Main/lazyLoad.js";
import Navigation from "@src/Admin/layout/navigation/navigation.js";
import AdminSidebar from "@src/Admin/layout/AdminSidebar/AdminSidebar.js";
import { dataCatalogItemSelector } from "@src/constants.js";

document.addEventListener("DOMContentLoaded", async function () {
  lazyLoad(".utils .search", "share/search");
  lazyLoad("#cache-clear", "share/clear_cache");

  lazyLoad([dataCatalogItemSelector], "admin/catalog_item");
  // lazyLoad(".h-cat_item", "share/header_categories");

  new Navigation();
  new AdminSidebar();
});
