import { debounce, formatter, post } from "../../common";
import { ael, qa } from "../../constants";
import CartBadge from "@components/shippable/CartBadge.js";
import Shippable_row from "@components/shippable/shippable_row.js";

export default class shippableTable {
  constructor(table) {
    if (!table) return;

    this.table = table;
    this.formatter = formatter;
    this.price = +this.table.dataset.price;
    this.sid = this.table
      .closest("[data-product_1s_id]")
      ?.dataset["product_1s_id"].trim();

    this.initRows();
    this.toServer = this.toServerRaw;
    this.table[ael]("click", this.handleClick.bind(this));
    // this.boundCountChange = debounce(this._dispatchEvent.bind(this), 100);
    this.table[ael](
      "shippable.count.changed",
      this.handleCountChange.bind(this),
    );
  }
  handleCountChange(e) {
    if (!this.getTotalCount()) this._dispatchEvent();

    const row = {
      value: e.detail.value,
      unit_id: e.detail.unit_id,
    };
    this.handleChange(row);
  }
  async handleChange(row) {
    if (this.getTotalCount() === 1) {
      window.YM?.("tovar_v_korzine");
    }

    const res = await this.toServer(this.dto(row));

    await this.updateCartBadge(res?.cart_count);
  }
  initRows() {
    const rows = this.getRows();
    [].map.call(rows, (row) => new Shippable_row(row));
  }

  getRows() {
    return this.table[qa]("[unit-row]");
  }

  handleClick({ target }) {
    const targ = target ?? this.table;

    if (targ.classList.contains("to-cart-button")) {
      window.location.href = "/cart";
    }
  }

  _dispatchEvent() {
    const event = new CustomEvent("shippable.product.empty", {
      bubbles: true,
      detail: this,
    });
    this.table.dispatchEvent(event);
  }

  getTotalCount() {
    return [...this.table[qa]("input")].reduce((acc, el) => {
      return acc + +el.value;
    }, 0);
  }

  updateCartBadge(cart_count) {
    const badge = new CartBadge();
    badge.setCount(cart_count);
  }

  async toServerRaw(order_item_dto) {
    return new Promise((resolve) => {
      debounce(async (dto) => {
        await post(`/cart/add`, dto).then(resolve);
      }, 100)(order_item_dto);
    });
  }

  dto(row) {
    return {
      product_1s_id: this.sid,
      count: row.value,
      unit_id: row.unit_id,
    };
  }
}
