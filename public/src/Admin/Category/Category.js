import '../Product/product.scss'
import './category.scss'
import PropertyTable from "./PropertyTable";
import {$, post} from "../../common.js";
import SelectNew from "../../components/select/SelectNew";
import QuillFactory from "@src/components/quill/QuillFactory.js";
import {QuillConst} from "@src/components/quill/QuillConstans.js";


export default class Category {
   constructor(el) {
      this.el = el;
      this.id = el.dataset.id
      this.setCategoryId()
      this.setProperties()
      QuillFactory.create('#seo-article', QuillConst.ADMIN_CATEGORY_SEO_ARTICLE);
   }

   setCategoryId() {
      const el = $(`[data-field='category_id']`).first()
      const parentSelector = new SelectNew(el);
   }

   setProperties() {
      new PropertyTable(this.el.querySelector(`[data-relation="properties"]`))
   }

   dto(change) {
      return {
         id: this.id,
         relation: "ownProperties",
         fields: {
            "seo_article": change,
         }
      }
   }
   attachCategory({detail}) {
      const data = {
         id: this.id,
         relation:detail.target.dataset.relationmodel,
         fields: {
            'category_id': +detail.next.value,
         }

      };
      post(`/adminsc/category/updateOrCreate`, data)
   }

}