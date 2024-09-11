import './main.scss'
import '../404/404.scss'

import {ael, qs} from '../constants';
import '../share/hoist/hoist';

document.addEventListener('DOMContentLoaded', async function () {

   const searchButton = document[qs]('.utils .search');
   if (searchButton) {
      const {default:Search} = await import('../components/search/search');
      new Search()
   }

   const gumburger = document[qs]('.gamburger');
   if (gumburger) {
      gumburger[ael]('click', function (e){
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


