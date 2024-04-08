import PropertyTable from "./PropertyTable";
import {$, post} from "../../common";
import SelectNew from "../../components/select/SelectNew";

export default class Category {
  constructor($el) {
    this.$el = $el;
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
      new SelectNew(this.$parent_category);
      this.$parent_category.addEventListener('customSelect.changed', this.attachCategory.bind(this))
    }
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


}