import './product.scss'
import './units.scss'
import {$, objAndFiles2FormData, post} from '../../common.js'
import './Props.js'
import {qs} from '../../constants'
import SelectNew from "@src/components/select/SelectNew.js";
import QuillFactory from "@src/components/quill/QuillFactory.js";
import {QuillConst} from "@src/components/quill/QuillConstans.js";

export default class Product {
   constructor() {
      const product = document[qs](`.item-wrap[data-model='product']`)
      if (!product) return false;
      this.product = product
      this.model = 'product'
      this.id = $(this.product).find(`[data-field='id']`).innerText

      this.setProps().then()

      this.setDragNDrop().then()
      this.setCardPanel().then()

      QuillFactory.create('.txt', QuillConst.ADMIN_PRODUCT_DESCRIPTION);
      QuillFactory.create('#seo-article', QuillConst.ADMIN_PRODUCT_SEO_ARTICLE);
      this.setUnitsCustomSelects()
   }

   setUnitsCustomSelects() {
      const units = $('.units [custom-select]');
      [].forEach.call(units, (unit) => {
         if (unit.dataset.id) new SelectNew(unit)
      })
   }

   async setDragNDrop() {
      const dragNdrop = document[qs]('[dnd]')
      if (dragNdrop) {
         const {default: Dnd} = await import("../../components/dnd/dnd")
         const dnd = await new Dnd(dragNdrop, this.addMainImage)
      }
   }

   async setFields() {
      const {default: Fields} = await import("./Fields.js")
      new Fields(this.product)
   }

   async setProps() {
      const {default: Props} = await import("./Props.js")
      new Props(this.product)
   }


   async setCardPanel() {
      const cardPanel = document[qs](`.cardPanel`)
      if (cardPanel) {
         const {default: cardPanel} = await import("./../../share/card_panel/card_panel")
         new cardPanel()
      }
   }

   async addMainImage(files, target) {
      const obj = {productId: target.closest('.item-wrap').dataset.id,};
      const data = objAndFiles2FormData(obj, files[0]);

      const res = await post('/adminsc/product/saveMainImage', data);
      const src = res?.arr[0];
      if (src) {
         const mainImage = target.closest('.dnd-container').querySelector('img');
         mainImage.removeAttribute("src");
         mainImage.setAttribute("src", src)
      }
   }

}




