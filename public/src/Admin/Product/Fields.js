import SelectNew from "../../components/select/SelectNew";
import {$} from "../../common";

export class Fields{
  constructor($product){
    this.$product = $product;
    this.$fields = $('.item_content');
    this.$category_id = $(`[data-field="category_id"]`).first();
    this.$base_unit = $(`[data-field="base_unit"]`).first();
    this.$manufacturer_id = $(`[data-field="manufacturer_id"]`).first();
    this.setup()
  }

  setup(){
    this.$fields.addEventListener('customSelect.changed',this.changeFields.bind(this));
    new SelectNew(this.$category_id);
    new SelectNew(this.$base_unit);
    new SelectNew(this.$manufacturer_id)
  }

  changeFields(){
    debugger;
    if(this.dataset.field='category_id'){

    }

  }
}