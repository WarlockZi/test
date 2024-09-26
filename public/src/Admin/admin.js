import './admin.scss'
import './model/cache.js';

import '../components/header/header-adm.js'
import '../components/search/search.js'
import '../components/accordion/accordion.js'
import '../components/AdminAccordion.js'
import '../components/date/date.js'

import {$} from "../common.js"

// import '../Test/test_results/test_results.js'
// import '../Test/opentest-edit.js'
// import testEdit from '../Test/test-edit.js'
// import '../Test/test-do.js'
// import '../Test/open_test.js'


import './sync1c/sync1c.js'
// import './chart/chart'.js
// import './chartjs/chartjs.js'
// import quill from '../components/quill/quill.js'


import './Planning/planning.js'
import './Settings/settings.js'
import './Videoinstructions/videoinstructions.js'
import Search from "../components/search/search.js"
import Promotion from "../Promotions/Promotion.js"
import './ProductFilter/ProductFilter'

import {qs} from '../constants'
import navigate from "./Navigate";
import '../components/table/table.js'
import CatalogItem from "../components/catalog-item/catalog-item.js";
import MyQuill from "../components/quill/quill.js";

import '../share/scroll/scroll.js'
import Accordion from "../components/accordion/accordion.js";
$(document).ready(async function () {

   const test = window.location.href.includes("/test")
   if (test){
      const {default:Test} = await import('./Test/index.js')
   }

   const AdminSidebar = $('.admin-sidebar').first()
   if (AdminSidebar){
      const {default: Accordion} = await import('../components/accordion/accordion.js')
      new Accordion(AdminSidebar)
   }
   // const product = document[qs](`.item-wrap[data-model='product']`)
   // if (product) {
      const {default: Product} = await import('./Product/Product.js')
      new Product();
   // }
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

   if (document[qs]('.admin_sidebar')) {
      const {default: adminAccordion} = await import('../components/AdminAccordion.js')
      new adminAccordion()
   }
   navigate(window.location.pathname);

   const customCatalogItem = $('.item-wrap')[0];
   if (customCatalogItem){
      new CatalogItem(customCatalogItem)
   }

   const chart = document.getElementById('income')
   if (chart){
      const {default: MyChart} = await import('./chartjs/chartjs.js')
   }
   const settings = window.location.pathname ==='/adminsc/settings'
   if (settings)   {
      const {default:Settings} = await import('./Settings/settings.js')
   }
   // tooltips();

   // const property = document[qs](`.properties[custom-table]`)
   // if (property) {
   //    const {default: Property} = await import('./Property/Property.js')
   //    new Property(property)
   // }
   // multiselect();
   // radio();
   // morph();
   // new MyQuill('#detail-text');
   // testEdit();




});



