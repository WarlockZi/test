import Quill from "quill";
import {QuillConst} from "@src/components/quill/QuillConstans.js";
import AdminProductDescrioption from "@src/components/quill/AdminProductDescrioption.js";

export default class QuillFactory {
   constructor() {
      this.quill = new Quill();
      debugger
   }
   static create(selector, type, options){
      if (type === QuillConst.ADMIN_PRODUCT_DESCRIPTION) {
         return new AdminProductDescrioption(selector, options)
      }

   }

}