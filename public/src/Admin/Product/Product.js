import './product.scss'
import './units'
import './Values'
import {objAndFiles2FormData, post} from '../../common'
import {qs} from '../../constants'

export default class Product {
   constructor(product) {
      if (!product) return false;
      this.product = product

      this.setValues()
      this.setFields()
      this.setDragNDrop()
      this.setCardPanel()
   }

   async setDragNDrop() {
      const dragNdrop = document[qs]('[dnd]')
      if (dragNdrop) {
         const {default: Dnd} = await import("../../components/dnd/dnd")
         new Dnd(dragNdrop, this.addMainImage)
      }
   }

   async setFields() {
      const {default: Fields} = await import("./Fields.js")
      new Fields(this.product)
   }

   async setValues() {
      const {default: Values} = await import("./Values.js")
      new Values(this.product)
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
      let data = objAndFiles2FormData(obj, files[0]);

      let res = await post('/adminsc/product/saveMainImage', data);
      let src = res?.arr[0];
      if (src) {
         const mainImage = target.closest('.dnd-container').querySelector('img');
         mainImage.removeAttribute("src");
         mainImage.setAttribute("src", src)
      }
   }

}




