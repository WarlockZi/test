import {$} from "../common.js"
import {qs} from '../constants'
import '../components/footer/footer.scss'
import '../components/popup.scss'
import './admin.scss'

import './model/cache.js';
import '../components/accordion/accordion.js'
import '../components/date/date.js'

import './sync1c/sync1c.js'
import './Planning/planning.js'
import './Settings/settings.js'
import './Videoinstructions/videoinstructions.js'
import './ProductFilter/ProductFilter'
import './Category/Category.js'


import AdminHeader from "../components/header/header-adm.js";
import Search from "../components/search/search.js"
// import '../components/table/Table.js'
import adminScroll from '../share/scroll/adminScroll.js'
import Navigation from "./components/Navigation.js";

import Pages from "@src/Admin/Pages/pages.js";
import Users from "@src/Admin/User/users.js";
import User from "@src/Admin/User/user.js";
import AdminSidebar from "@src/Admin/components/AdminSidebar/AdminSidebar.js";
// import ProductFilter from "../Admin/ProductFilter/ProductFilter.js";
// import Promotion from "@src/Promotions/Promotion.js";


$(document).ready(async function () {

   document.body.classList.remove('preload');

   const admin = window.location.pathname.includes('adminsc')
   if (!admin) return false

   const table = $('[custom-table]').first()
   if (table) {
      const {default: Tables} = await import( '../components/table/Tables.js')
      // new Tables
   }
   new Search(true);
   new Navigation;
   new AdminHeader()
   adminScroll()
   new AdminSidebar($('.sidebar').first())


   if (window.location.pathname === '/adminsc/pages') {
      new Pages
   } else if (window.location.pathname === '/adminsc/user') {
      new Users
   } else if (window.location.pathname.startsWith('/adminsc/user/edit')) {
      new User
   } else if (window.location.href.includes("/test")) {
      const {default: Test} = await import('./Test/index.js')
   } else if (window.location.pathname === '/adminsc') {
      const {default: MyChart} = await import('./chartjs/chartjs.js')
   } else if (window.location.pathname === '/adminsc/report/filter') {
      const {default: ProductFilter} = await import('./ProductFilter/productFilter.js')
      new ProductFilter($('.products-filter').first())
   }
   // else if (window.location.pathname.startsWith('/adminsc/test/do')){
   //    new TestDo($('.test-do').first())
   // }
   const promotion = $('.promotion-edit').first();
   if (promotion) {
      const {default:Promotion} = await import("@src/Promotions/Promotion.js")
      new Promotion;
   }

   if (document[qs]('.modal')) {
      const {default: Modal} = await import("../components/Modal/modal.js")
      new Modal
   }

   const cardPanel = document[qs](`.card-panel`)
   if (cardPanel) {
      const {default: Card_panel} = await import("./../share/card_panel/card_panel")
      new Card_panel()
   }

   const product = document[qs](`.item-wrap[data-model='product']`)
   if (product) {
      const {default: Product} = await import('./Product/Product.js')
      new Product();
   }
   const catalogItem = document[qs]('.item-wrap')
   if (catalogItem) {
      const {default: CatalogItem} = await import('./components/catalog-item/catalog-item.js')
      new CatalogItem(catalogItem)
   }

   if (document[qs]('.order-edit')) {
      const {default: Order} = await import('./Order/order.js')
      new Order()
   }

   const category = document[qs](`.item-wrap[data-model='category']`)
   if (category) {
      const {default: Category} = await import('./Category/Category.js')
      new Category(category)
   }

});



