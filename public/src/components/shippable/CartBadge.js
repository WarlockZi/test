import { $ } from "../../common.js";

export default class CartBadge {
  constructor() {
    this.headerCart = $(".cart-link").first();
    this.badge = $(".cart-link .count").first() ?? this._createBadge();
    this.count = +this.badge.innerText;
  }
  _createBadge() {
    if (!this.headerCart) return;
    const badge = document.createElement("div");
    badge.classList.add("count");
    badge.innerText = "0";
    this.headerCart.append(badge);
    return badge;
  }
  setCount(count) {
    if (count) {
      this.badge.classList.remove("none");
      this.badge.classList.add("show");
      this.badge.innerText = count;
    } else {
      this.badge.remove();
    }
  }

  decrement() {
    if (this.count > 1) {
      this.setCount(--this.count);
    } else {
      this.badge.remove();
    }
  }
}
