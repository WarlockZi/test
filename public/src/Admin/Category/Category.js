import '../Product/product.scss'
import './category.scss'
import PropertyTable from "./PropertyTable";
import {$, post} from "../../common";
import SelectNew from "../../components/select/SelectNew";
import Morph from "../../components/morph/morph";

export default class Category {
  constructor($el) {
    this.$el = $el;
    this.id = $el.dataset.id
    this.$properties_table = this.$el.querySelector('.properties');
    this.$parent_category = $(`[data-field='category_id']`).first();
    this.$mainImage = this.$el.querySelector('.mainImage');
    this.setup();
    this.dto = this.dto()
  }


  setup(){
    if (this.$properties_table) {
      new PropertyTable(this.$properties_table)
    }
    if (this.$parent_category) {
      const parentSelector = new SelectNew(this.$parent_category);
      parentSelector.sel.addEventListener('customSelect.changed', this.attachCategory.bind(this))
    }
    const dnds = $('[data-dnd]');
    dnds.forEach((dnd) => {
      if (dnd.parentNode.dataset.morphModel) {
        let m = new Morph(dnd, $category)
      }
    });
  }


  dto() {
    return {
      id: this.$el.dataset.id,
    }
  }


  attachCategory({detail}) {
    debugger;
    let data = {
      id: this.id,
      category_id: +detail.next.value,
    };
    post('/adminsc/category/updateOrCreate', data)

  }

// let dto = {
//   id: +$category.dataset.id,
// };

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