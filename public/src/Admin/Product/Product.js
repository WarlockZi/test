import './product.scss'
import './units'
import './Props.js'
import {objAndFiles2FormData, post} from '../../common.js'
import {qs} from '../../constants'
import MyQuill from "../../components/quill/MyQuill.js";

export default class Product {
   constructor() {
      const product = document[qs](`.item-wrap[data-model='product']`)
      if (!product) return false;
      this.product = product

      this.setProps().then()

      this.setFields().then()
      this.setDragNDrop().then()
      this.setCardPanel().then()
      new MyQuill('#detail-text');
      new MyQuill('#seo_article', true,true,true);
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




