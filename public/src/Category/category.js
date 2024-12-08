import {ael, qa, qs} from '../constants';
import shippableTable from "../share/shippable/shippableUnitsTable";
import MyQuill from "../components/quill/MyQuill.js";
// import Card_panel from "../share/card_panel/card_panel";

export default class Category {
   constructor() {
      this.category = document[qs]('.category');
      if (!this.category) return false;
      this.setCardPanel().then()
      this.mapShippableTables()

      new MyQuill('#seo_article');
      this.category[ael]('click', this.handleClick.bind(this))

   }

   async setCardPanel() {
      const cardPanel = document[qs](`.card-panel`)
      if (cardPanel) {
         const {default: Card_panel} = await import("./../share/card_panel/card_panel")
         this.cardPanel = new Card_panel()
      }
   }

   handleClick({target}) {
      if (target.classList.contains('blue-button')) {
         const table = target.closest('[shipable-table]')
      } else if (target.classList.contains('short-link')) {
         this.cardPanel.shortLink(target)
      }
   }


   mapShippableTables() {
      [...this.category[qa]('.shippable-table')]
         .forEach((table) => {
            new shippableTable(table)
         })
   }

}

