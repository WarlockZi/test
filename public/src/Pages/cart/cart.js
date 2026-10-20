import "./cart.scss";
import { $, formatter, post } from "@src/common.js";
import { ael, it, qa, qs } from "@src/constants.js";
import shippableTable from "@components/shippable/shippableTable.js";
import renderSums from "@src/Pages/cart/renderSums.js";

export default class Cart {
  constructor() {
    window.YM("url_cart");

    this.container = $(".user-content .cart .content").first();
    if (!this.container) return;

    this.container[ael]("click", this.handleClick.bind(this));
    this.container[ael]("keyup", this.handleKeyUp.bind(this));

    // this.orderId = this.container[qs]("[data-orders-id]").dataset.orderId;
    this.total = this.container[qs](".total span");
    this.$cartEmptyText = this.container[qs](".empty-cart");
    this.$cartCount = this.container[qs](".cart .count");
    this.rows = this.container[qa](".row");

    this.mapTables();
    this.renderSums();
  }

  async submitCart() {
    const res = post("/cart/submit", {});
    if (res.ok) {
    }
  }

  rowUnits(row) {
    const rows = {};
    [...row[qa]("[unit-row]")].map((unitRow) => {
      const unitid = unitRow.dataset.unitid;
      const count = +unitRow[qs]("input").value;
      if (count) rows[unitid] = count;
    });
    return rows;
  }

  cartRowDTO(target) {
    const row = target.closest(".row");
    return {
      // order_id: this.orderId,
      product_1s_id: row.dataset.product_1s_id,
    };
  }

  renderSums() {
    renderSums({
      shippable_tables: this.container[qa](".shippable-table"),
      total: this.total,
    });
  }

  mapTables() {
    [...this.container[qa](".shippable-table")].forEach((table) => {
      new shippableTable(table);
    });
  }

  async handleClick({ target }) {
    if (target.classList.contains("del")) {
      await this.deleteCartRow(target);
      this.renderSums();
    } else if (
      target.classList.contains("plus") ||
      target.classList.contains("minus")
    ) {
      this.renderSums();
    } else if (target.id === "cartSubmit") {
      YM("cart_submitted");
      this.submitCart();
    }
  }

  async handleKeyUp({ target }) {
    if (target.classList.contains("input") && target.tagName === "INPUT") {
      this.renderSums();
      this.updateOrCreate(target);
    }
  }

  rowTotalCount(table) {
    return [...table[qa]("input")].reduce((acc, el) => {
      return acc + +el.value;
    }, 0);
  }

  async updateOrCreate(target) {
    const count = +target.value;
    const orderItemId = target.dataset.orderItemId;
    // const unit_id = target.closest("[unit-row]").dataset["unitid"];
    await post(`/cart/updateOrCreate`, { orderItemId, count });
  }

  async deleteCartRow(target) {
    const res = await post(`/cart/deleteRow`, this.cartRowDTO(target));
    if (res?.deleted) {
      target.closest(".row").remove();
      if (this.rows.length < 1) this.showEmptyCart();
      this.renderSums();
    }
  }

  showEmptyCart() {
    this.container.innerHTML = "";
    this.$cartEmptyText.classList.remove("none");
    this.$cartCount.classList.add("none");
  }
}
