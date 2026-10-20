//TODO
import { $, post } from "@src/common.js";
import "./order.scss";
import "@src/Pages/cart/cart.scss";
import renderSums from "@src/Pages/cart/renderSums.js";

export default class Order {
  constructor() {
    this.$order = $("#order").first();
    if (!this.$order) return;

    this.in_process_checkbox = $(`[data-order_id]`).first();
    if (this.in_process_checkbox) {
      this.in_process_checkbox.addEventListener(
        "change",
        this.orderInProcess.bind(this),
      );
    }

    renderSums({
      shippable_tables: $(this.$order).findAll(".shippable-table"),
      total: $(".total span").first(),
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
