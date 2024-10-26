import './main.scss'
import '../components/header/show-front-menu1.js';
import '../404/404.scss'

import {ael, qs} from '../constants';
import '../share/hoist/hoist';

import '../components/animate/animate.js'
import scroll from '../share/scroll/scroll.js'
import headerMenu from '../components/header/show-front-menu.js'

document.addEventListener('DOMContentLoaded', async function () {
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

   headerMenu()
   scroll()
   const admin = window.location.pathname.includes('adminsc')
   if (admin) return false

   const searchButton = document[qs]('.utils .search');
   if (searchButton) {
      const {default: Search} = await import('../components/search/search');
      new Search()
   }

   const gumburger = document[qs]('.gamburger');
   if (gumburger) {
      gumburger[ael]('click', function (e) {
         const mm = e.target.closest('.utils')[qs]('.mobile-menu');
         mm.classList.toggle('show')
      })
   }
   // debugger
   const modal = document[qs]('.modal-wrapper')
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
});


