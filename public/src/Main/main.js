import "./main.scss";
import "@components/header/show-front-menu1.js";
import "@components/hoist/hoist.js";
import "@components/animate/heroAnimate.js";
import { qs } from "../constants";
import scroll from "@components/scroll/scroll.js";
import headerMenu from "@components/header/show-front-menu.js";

import adminPanel from "@components/adminPanel/adminPanel.js";

import IntObserver from "@components/scroll/IntObserver.js";
import MobileMenu from "@components/header/mobile-menu.js";
import CartLogin from "@src/Auth/CartLogin.js";
import CatalogItem from "@src/Admin/components/catalog-item/catalog-item.js";
import { $ } from "@src/common.js";
import Search from "@components/search/search.js";
import CallMe from "@src/CallMe/CallMe.js";
import Feedback from "@src/Feedback/Feedback.js";
import setLocalStorageGuestId from "@components/cart_id/cart_id.js";

import YM from "@src/Main/YM.js";
import "./d-goals.js";
import "./demis/feed_back.js";

import Chat from "@components/chat/chat.js"; //не удалять - стили пропадут
import Modal from "@components/Modal/modal.js";
// import "../404/404.scss";

window.YM = YM;
document.addEventListener("DOMContentLoaded", async function () {
  const admin = window.location.pathname.includes("adminsc");
  if (admin) return false;

  document.body.classList.remove("preload"); //to prevent initial transitions

  const feedbackButton = $("#feedback-submit").first();
  if (feedbackButton) new Feedback(feedbackButton);

  // new ChatLocalStorage();
  new CallMe();
  new Search();
  new MobileMenu();

  const modal = document[qs](".modal");
  if (modal) {
    const { default: Modal } = await import("../components/Modal/modal.js");
    new Modal({
      triggers: [".guest-menu", "#cartLogin"],
      boxes: new CartLogin(),
    });
  }
  IntObserver();
  headerMenu();
  scroll();
  setLocalStorageGuestId();

  new adminPanel();

  const path = window.location.pathname;
  if (path.startsWith("/auth/profile")) {
    new CatalogItem($(".item-wrap").first());
  } else if (path.startsWith("/cart")) {
    YM("url_cart");
    const { default: Cart } = await import("../Cart/Cart.js");
    new Cart();
  } else if (path.startsWith("/like/page")) {
    const { default: Like } = await import("../Like/Like.js");
    new Like();
  } else if (path.startsWith("/compare/page")) {
    const { default: Compare } = await import("../Compare/Compare.js");
    new Compare();
  } else if (path.startsWith("/catalog")) {
    const { default: Category } = await import("../Category/category.js");
    new Category();
  } else if (path.startsWith("/product")) {
    const { default: Product } = await import("../Product/Product.js");
    new Product();
  } else if (path.startsWith("/promotions")) {
    const { default: Promotions } =
      await import("../Admin/Pages/promotion/promotion.js");
    new Promotions();
  }
});
