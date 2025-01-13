import './main.scss'
import '../components/header/show-front-menu1.js';
import '../404/404.scss'
import '../share/hoist/hoist';
import '../share/chat/Chat';
import '../components/animate/animate.js'
import {ael, qs} from '../constants';
import scroll from '../share/scroll/scroll.js'
import headerMenu from '../components/header/show-front-menu.js'

import IntObserver from "../share/scroll/IntObserver.js";
import MobileMenu from "@src/components/header/mobile-menu.js";
import Modal from "@src/components/Modal/modal.js";
import CartLogin from "@src/Auth/CartLogin.js";
import CatalogItem from "@src/Admin/components/catalog-item/catalog-item.js";
import {$} from "@src/common.js";
import YM from "@src/Main/YM.js";
import Search from "@src/components/search/search.js";
import ChatLocalStorage from "@src/share/chatLocalStorage/ChatLocalStorage.js";
import Chat from "@src/share/chat/chat.js";
import Feedback from "@src/Feedback/Feedback.js";
import CallMe from "@src/CallMe/CallMe.js";

window.YM = YM
document.addEventListener('DOMContentLoaded', async function () {

   document.body.classList.remove('preload');//to prevent initial transitions

   const feedbackButton = $('#feedback-submit').first()
   if (feedbackButton) new Feedback(feedbackButton)

   new Chat()
   new ChatLocalStorage()

   const path = window.location.pathname;
   if (path.startsWith('/auth/profile')) {
      new CatalogItem($('.item-wrap').first())

   }
   else if (path.startsWith('/cart')) {
      YM('url_cart')
      const {default: Cart} = await import('../Cart/Cart.js')
      new Cart()
   }
   else if (path.startsWith('/like/page')) {
      const {default: Like} = await import('../Like/Like.js')
   }
   else if (path.startsWith('/compare/page')) {
      const {default: Compare} = await import('../Compare/Compare.js')
      new Compare()
   }
   IntObserver()
   headerMenu()
   scroll()

   new CallMe
   new Search
   new MobileMenu

   const admin = window.location.pathname.includes('adminsc')
   if (admin) return false


   new Modal({
      triggers: ['.guest-menu', '#cartLogin'],
      boxes: new CartLogin(),
   });


   const modal = document[qs]('.modal')
   if (modal) {
      const {default: Modal} = await import("../components/Modal/modal.js")
      new Modal()
   }

   const category = document[qs]('.category')
   if (category) {
      const {default: Category} = await import('../Category/category.js')
      new Category()
   }
   const product = document[qs]('.product-card')
   if (product) {
      const {default: Product} = await import('../Product/Product.js')
      new Product()
   }

   const promotions = document[qs]('.promotions-index')
   if (promotions) {
      const {default: Promotions} = await import('../Promotions/Promotion.js')
      new Promotions;
   }


});


