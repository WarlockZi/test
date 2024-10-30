import {$} from "../common.js"
import {qs} from '../constants'
import './common.js'

import './sync1c/sync1c.js'
import './Planning/planning.js'
import './Settings/settings.js'
import './Videoinstructions/videoinstructions.js'
import './ProductFilter/ProductFilter'
import './Category/Category.js'

import Promotion from "../Promotions/Promotion.js"

import Search from "../components/search/search.js"
import Navigate from "./components/Navigate.js";
import '../components/table/table.js'
import '../components/popup.scss'
import adminScroll from  '../share/scroll/adminScroll.js'

import AdminHeader from "../components/header/header-adm.js";
import '../components/footer/footer.scss'



$(document).ready(async function () {

   const cardPanel = document[qs](`.card-panel`)
   if (cardPanel) {
      const {default: Card_panel} = await import("./../share/card_panel/card_panel")
      new Card_panel()
   }

   adminScroll()
   const admin = window.location.pathname.includes('adminsc')
   if (!admin) return false

   new AdminHeader()


   const test = window.location.href.includes("/test")
   if (test){
      const {default:Test} = await import('./Test/index.js')
   }

   const AdminSidebar = $('.sidebar').first()
   if (AdminSidebar){
      const {default: Accordion} = await import('../Admin/components/AdminSidebar/AdminSidebar.js')
      new Accordion(AdminSidebar)
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

   if (document[qs]('.modal-wrapper')) {
      const {default: Modal} = await import("../components/Modal/modal.js")
      new Modal
   }

   const category = document[qs](`.item-wrap[data-model='category']`)
   if (category) {
      const {default: Category} = await import('./Category/Category.js')
      new Category(category)
   }
   new Promotion();
   new Search(true);


   Navigate(window.location.pathname);

   const chart = document.getElementById('income')
   if (chart){
      const {default: MyChart} = await import('./chartjs/chartjs.js')
   }
});



