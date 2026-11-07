//TODO
import { $, post } from "@src/common.js";
import "./order.scss";
import "@src/Pages/cart/cart.scss";
import renderSums from "@src/Pages/cart/renderSums.js";
import checkboxes from "@components/checkboxes/checkboxes.js";

export default class Order {
  constructor() {
    this.$order = $("#order").first();
    if (!this.$order) return;

    this.setInProcessHandlers();


    this._renderSums();
  }

  setInProcessHandlers(){
    const in_process_checkboxes =  $(`[data-order_id]`);
    if (!in_process_checkboxes) return;
      [].forEach.call(in_process_checkboxes, (checkbox) => {
        checkbox.addEventListener("change", this.orderInProcess.bind(this));
      });
  }

  _renderSums() {
    const orders = $(".order .order-details");
    [].forEach.call(orders, (order) => {
      renderSums({
        shippable_tables: $(order).findAll(".shippable-table"),
        total: $(order).find(".total span"),
      });
    });
  }
  async orderInProcess({ target }) {
    const data = {
      order_id: target.dataset.order_id,
      in_process: target.checked,
    };
    const res = await post("/adminsc/order/inprocess", data);
  }
  dto(self, detail) {
    return {
      id: self.id,
      prev: detail?.prev,
      next: detail?.next,
    };
  }
}
