import "./values.scss";
import { $, post } from "../../common.js";
import SelectNew from "../../components/select/SelectNew";

export default class Props {
  constructor($product) {
    this.$product = $product;
    this.properties = $($product).find(".values");
    this.values = this.properties.querySelectorAll(".value");
    this.properties.addEventListener(
      "customSelect.changed",
      this.selectChanged.bind(this),
    );
    this.values.forEach((value) => {
      new SelectNew(value);
    });
  }

  dto() {
    return {
      product_id: this.$product.dataset.id,
      morphed: {
        old_id: 0,
        new_id: 0,
      },
    };
  }

  async selectChanged(obj) {
    let data = this.dto();
    data.morphed.old_id = obj.detail.prev.value;
    data.morphed.new_id = obj.detail.next.value;
    let res = await post(`/adminsc/product/changeVal`, data);
  }
}
