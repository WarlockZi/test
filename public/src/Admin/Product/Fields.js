import SelectNew from "../../components/select/SelectNew";
import {$, post} from "../../common.js";

export default class Fields {
  constructor($product) {
    this.$product = $product;
    this.$fields = $('.item_content').first();

    this.$category_id = $(`[data-field="category_id"]`).first();
    this.$promotions = $(`[data-field="active_promotions"]`).first();
    this.$base_unit = $(`[data-field="base_unit"]`).first();
    this.$manufacturer_id = $(`[data-field="manufacturer_id"]`).first();
    this.$printName = $(`[data-field='print_name']`).first();
    this.$printName.addEventListener('catalogItem.changed', this.changePrintName.bind(this))

    this.$productUrl= $(`[data-field='slug']`).first();
    this.setup()
  }

  setup() {
    this.$fields.addEventListener('customSelect.changed', this.changeFields.bind(this));
    new SelectNew(this.$category_id);
    new SelectNew(this.$promotions);
    new SelectNew(this.$base_unit);
    new SelectNew(this.$manufacturer_id);
  }

  changePrintName(item) {
    if (item.detail) {
      let $url = this.$productUrl.querySelector('a')
      let slug = item.detail?.res?.arr?.model.slug
      $url.setAttribute('href',`/product/${slug}`)
      $url.text = slug
    }

  }

  async checkBoxChanged({target}) {
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