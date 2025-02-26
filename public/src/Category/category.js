import {ael, qa, qs} from '../constants';
import shippableTable from "../share/shippable/shippableUnitsTable";
import MyQuill from "../components/quill/MyQuill.js";
import {post} from "@src/common.js";
import DTO from "@src/Admin/DTO.js";

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
      }

      if (target.hasAttribute('data-like')) {
         this.handleLike(target)

      } else if (target.hasAttribute('data-compare')) {
         this.handleCompare(target)

      } else if (target.classList.contains('short-link')) {
         this.cardPanel.shortLink(target)
      }
   }
   async handleCompare(target){
      if (!target.dataset.compare) {
         target.dataset.compare = false
         const res = await post('/compare/del', this.productDTO(target))
         if (res?.arr?.discompared) target.classList.toggle('green');

      } else {
         target.dataset.compare = true
         const res = await post('/compare/updateOrCreate', this.productDTO(target))
         if (res?.arr?.compared) target.classList.toggle('green');
      }
   }
   async handleLike(target){
      if (!target.dataset.like) {
         target.dataset.like = false
         const res = await post('/like/del', this.productDTO(target))
         if (res?.arr?.disliked) target.classList.toggle('red');
      } else {
         target.dataset.like = true
         const res = await post('/like/updateOrCreate', this.productDTO(target))
         if (res?.arr?.liked) target.classList.toggle('red');
      }
   }

   productDTO(target) {
      const dto = new DTO(target);
      dto.fields = {
         product_id: target.closest(`[data-1sid]`).dataset['1sid'],
      }
      return dto
   }


   mapShippableTables() {
      [...this.category[qa]('.shippable-table')]
         .forEach((table) => {
            new shippableTable(table)
         })
   }

}

