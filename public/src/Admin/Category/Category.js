import '../Product/product.scss'
import './category.scss'
import PropertyTable from "./PropertyTable";
import {$, post} from "../../common.js";
import SelectNew from "../../components/select/SelectNew";
import MyQuill from "../../components/quill/MyQuill.js";


export default class Category {
   constructor(el) {
      this.el = el;
      this.id = el.dataset.id

      this.setCategoryId()
      this.setShowOnFrontPage()
      this.setProperties()
      this.setImage()
      new MyQuill('#seo_article', true,true,true);
   }

   setCategoryId() {
      const el = $(`[data-field='category_id']`).first()
      const parentSelector = new SelectNew(el);
      parentSelector.sel.addEventListener('customSelect.changed', this.attachCategory.bind(this))

   }

   setProperties() {
      new PropertyTable(this.el.querySelector(`[data-relation="properties"]`))
   }

   setShowOnFrontPage() {
      // new Checkbox(this.el.querySelector(`[data-relation="properties"]`))
   }

   setImage() {
      // this.$mainImage = this.$el.querySelector('.mainImage');
      // new Morph($('[data-dnd]').first(), $category)
      // this.__dto = this.dto()
   }

   dto() {
      return {
         id: this.el.dataset.id,
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


// async function addMainImg(files) {
//   let catId = $('.item-wrap')[0].dataset.id;
//   let slugNameId = 1;
//   let imagable = new Imageable();
//   let morph = await new Morph(imagable, new Category(catId, slugNameId), files);
//
//   let src = await post(imagable.urlOne, morph?.data);
//   let appendTo = ".image[data-model='category']";
//   let appendOneImage = morph.appendOneImage(appendTo, src?.arr[0])
// }
}