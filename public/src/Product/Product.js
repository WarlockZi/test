import './product.scss'
import {zoom} from './zoom'
import Card_panel from '../share/card_panel/card_panel'
import {$} from "../common";
import shippableTable from "../share/shippable/shippableUnitsTable";
import MyQuill from "../components/quill/MyQuill.js";


export default class Product{

   constructor(){
      const product = $('.product-card').first();
      if (!product) return false
      const table = $('.shippable-table').first()

      new shippableTable(table)

      const short_link = $('.short-link').first()
      if (short_link) {
         short_link.addEventListener('click', function ({target}) {
            const cardPanel = new Card_panel()
            cardPanel.shortLink(target)
         })
      }

      zoom()
      new MyQuill('#seo-article');
      new MyQuill('#detail-text');
   }
}

