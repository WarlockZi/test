import './main.scss'
import '../components/header/show-front-menu1.js';
import '../404/404.scss'
import '../share/hoist/hoist';
// import '../components/animate/animate.js'
import {qs} from '../constants';
import scroll from '../share/scroll/scroll.js'
import headerMenu from '../components/header/show-front-menu.js'

import IntObserver from "../share/scroll/IntObserver.js";
import MobileMenu from "@src/components/header/mobile-menu.js";
import Modal from "@src/components/Modal/modal.js";
import CartLogin from "@src/Auth/CartLogin.js";

document.addEventListener('DOMContentLoaded', async function () {

   IntObserver()
   headerMenu()
   scroll()
   const admin = window.location.pathname.includes('adminsc')
   if (admin) return false

   const searchButton = document[qs]('.utils .search');
   if (searchButton) {
      const {default: Search} = await import('../components/search/search');
      new Search()
   }

   new Modal({
      triggers: ['.guest-menu', '#cartLogin'],
      boxes: new CartLogin(),
   });

   // const gumburger = document[qs]('.gamburger');
   new MobileMenu()

   // const gumburger = document[qs]('.gamburger');
   // if (gumburger) {
   //    gumburger[ael]('click', function (e) {
   //       const mm = e.target.closest('.utils')[qs]('.mobile-menu');
   //       mm.classList.toggle('show')
   //    })
   // }
   // debugger
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

   const cart = document[qs]('.user-content .cart')
   if (cart) {
      const {default: Cart} = await import('../Cart/cart.js')
      new Cart()
   }
   // window.YaAuthSuggest.init(
   //    {
   //       client_id: "1cacd478c22b49c1a22e59ac811d0fc0",
   //       response_type: "token",
   //       redirect_uri: "https://vitexopt.ru/auth/yandex"
   //    },
   //    "https://vitexopt.ru",
   // )
   //    .then(({handler}) => handler())
   //    .then(data => console.log('Сообщение с токеном', data))
   //    .catch(error => console.log('Обработка ошибки', error))

   // YaSendSuggestToken(
   //    'https://vitexopt.ru',
   //    {
   //       flag: true
   //    }
   // )

});


