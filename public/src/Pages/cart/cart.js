import "./cart.scss";
import { $, post } from "@src/common.js";
import { ael, qa, qs } from "@src/constants.js";
import shippableTable from "@components/shippable/shippableTable.js";
import renderSums from "@src/Pages/cart/renderSums.js";
import CartBadge from "@components/shippable/CartBadge.js";

export default class Cart {
  constructor() {
    this.container = $(".user-content .cart .content").first();
    if (!this.container) return;

    window.YM("url_cart");

    this.container[ael]("click", this.handleClick.bind(this));
    this.container[ael]("keyup", this.handleKeyUp.bind(this));
    this.container[ael](
      "shippable.product.empty",
      this.handleProductEmpty.bind(this),
    );

    this.total = this.container[qs](".total span");
    this.$cartCount = this.container[qs](".cart .count");

    this.$cartEmptyText = this.container[qs](".empty-cart");
    this.rows = this.container[qa](".row");

    this.initShippableTables();
    this.renderSums();
  }
  async handleProductEmpty({ target }) {
    await this.deleteCartRow(target);
    this.renderSums();
  }

  async submitCart() {
    const res = post("/cart/submit", {});
    if (res.ok) {
    }
  }

  cartRowDTO(target) {
    const row = target.closest(".row");
    return {
      product_1s_id: row.dataset.product_1s_id.trim(),
    };
  }

  initShippableTables() {
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

  async updateOrCreate(target) {
    const count = +target.value;
    const orderItemId = target.dataset.orderItemId;
    await post(`/cart/updateOrCreate`, { orderItemId, count });
  }

  async deleteCartRow(target) {
    const res = await post(`/cart/deleteRow`, this.cartRowDTO(target));
    if (res?.deleted) {
      const product = target.closest(".row");
      this.removeFromCart(product);

      // target.closest(".row").remove();

      if (this.rows.length < 1) this.showEmptyCart();
      this.renderSums();
      const cartBadge = new CartBadge();
      cartBadge.decrement();
    }
  }
  async removeFromCart(cartItem) {
    if (!cartItem) return;

    const height = cartItem.offsetHeight;
    cartItem.style.height = `${height}px`;
    cartItem.classList.add("removing");

    // Используем Web Animations API для точного контроля
    const animation = cartItem.animate(
      [
        { opacity: 1, transform: "translateY(0)", marginBottom: "0" },
        {
          opacity: 0,
          transform: "translateY(-20px) scale(0.95)",
          marginBottom: `-${height}px`,
        },
      ],
      {
        duration: 300,
        easing: "ease-in-out",
        fill: "forwards",
      },
    );
    await animation.finished;
    cartItem.remove();
  }

  showEmptyCart() {
    this.container.innerHTML = "";
    this.$cartEmptyText.classList.remove("none");
    this.$cartCount.classList.add("none");
  }
  renderSums() {
    renderSums({
      shippable_tables: this.container[qa](".shippable-table"),
      total: this.total,
    });
  }
}
