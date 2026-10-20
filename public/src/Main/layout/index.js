import "@modules/main/header_slider/header_slider.js";

import "./d-goals.js";
import lazyLoad from "@src/Main/lazyLoad.js";
import Header_slider from "@src/Modules/main/header_slider/header_slider.js";
import { $ } from "@src/common.js";
import YM from "@src/Modules/main/YM/YM.js";
import Feed_back from "@src/Modules/main/feed_back/feed_back.js";
// import MyCardPanels from "@src/Modules/admin/card_panel/MyCardPanels.js";
// import set_guest_id from "@src/Modules/share/guest_id/set_guest_id.js";

window.YM = YM;

document.addEventListener("DOMContentLoaded", async function () {
  lazyLoad(".guest-menu", "main/login");
  lazyLoad("#cartLogin", "main/login");

  lazyLoad(".hoist", "share/hoist");
  lazyLoad(".hoist", "main/feed_back");

  lazyLoad("#call-me", "main/call_me");
  lazyLoad("#fixed-call-me", "main/call_me");
  lazyLoad("#burger-call-me", "main/call_me");

  lazyLoad(".utils .search", "share/search");

  lazyLoad("#cache-clear", "share/clear_cache");

  lazyLoad("#ham", "main/mobile_menu");

  lazyLoad(".header-catalog-menu__wrap", "share/header_categories");

  // headerMenu($(".header-catalog-menu__wrap").first());
  new Header_slider($("header").first());
  // new set_guest_id();

  new Feed_back();
  // new MyCardPanels();
});
