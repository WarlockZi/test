import SelectNew from "../../components/select/SelectNew";
import {$, post} from "../../common";

export class Fields {
  constructor($product) {
    this.$product = $product;
    this.$fields = $('.item_content').first();
    this.$category_id = $(`[data-field="category_id"]`).first();
    this.$base_unit = $(`[data-field="base_unit"]`).first();
    this.$manufacturer_id = $(`[data-field="manufacturer_id"]`).first();
    this.$base_equals_main_unit = $(`[data-field="base_equals_main_unit"]`).first();
    this.setup()
  }

  setup() {
    this.$fields.addEventListener('customSelect.changed', this.changeFields.bind(this));
    new SelectNew(this.$category_id);
    new SelectNew(this.$base_unit);
    new SelectNew(this.$manufacturer_id);
    this.$base_equals_main_unit.addEventListener('change', this.checkBoxChanged.bind(this))
  }

  async checkBoxChanged({target}){
    let data = this.dto(this);
    data[target.dataset.field] = +target.checked;
    let res = await post('/adminsc/product/updateOrCreate', data)
  }

  async changeFields(obj) {
    let field = obj.detail.target.dataset.field;
    if (!field) return;
    let data = this.dto(obj);
    data[field] = obj.detail.next.value;
    let res = await post('/adminsc/product/updateOrCreate', data)
  }

  dto(obj) {
    return {
      id: this.$product.dataset.id,
    }
  }
}