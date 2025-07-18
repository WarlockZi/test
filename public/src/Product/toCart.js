import { $, debounce, getPhpSession, post } from "../common";
import shippableTable from "@components/shippable/shippableUnitsTable";
import { d, qs } from "../constants";

export default class toCart {
  constructor() {
    this.toCart = $(".shippable-table").first();
    if (!this.toCart) return;
    new shippableTable(d[qs](".shippable-table"));
    this.count = document.querySelector(".utils .cart .count");
    this.adjust = this.toCart.querySelector(".adjust");
    this.blue = this.toCart.querySelector(".blue");
    this.digitEl = this.toCart.querySelector(".digit");
    // this.digit = +this.toCart.querySelector('.digit').innerText;
    // this.product = this.toCart.closest('.product-card').dataset.id;
    // this.shippableSelector = this.toCart.querySelector('#shippableSelector')
    // this.shippableSelector.addEventListener('change', this.changeShippable.bind(this))

    this.digitEl.onkeydown = debounce(this.keyDown.bind(this), 1300);
    this.toCart.onclick = this.handleClick.bind(this);
  }

  changeShippable() {
    // const shippableId = this.getShippableId()
    this.updateOrCreate();
  }

  getShippableId() {
    const index = this.shippableSelector.options.selectedIndex;
    return this.shippableSelector.options[index].value;
  }

  async updateOrCreate() {
    const dto = this.dto();
    let res = await post("/adminsc/OrderItem/updateOrCreate", dto);
    console.log(res);
  }

  dto() {
    return {
      sess: getPhpSession(),
      product_id: this.product,
      count: +this.digitEl.innerText,
      unit_id: +this.getShippableId(),
    };
  }

  showBlue() {
    this.blue.classList.remove("none");
    this.adjust.classList.add("none");
    this.count.innerText = --this.count.innerText;
  }

  showGreen() {
    this.blue.classList.add("none");
    this.adjust.classList.remove("none");
    this.count.innerText = ++this.count.innerText;
  }

  keyDown(e) {
    if (isNaN(+e.key) && e.key !== "Backspace") {
      e.preventDefault();
    }
    this.updateOrCreate();
  }

  handleClick({ target }) {
    if (target.classList.contains("blue")) {
      this.showGreen();
      this.debounced(this.updateOrCreate.bind(this));
    } else if (target.classList.contains("minus")) {
      if (this.digit > 1) {
        this.digitEl.innerText = --this.digit;
        this.debounced(this.updateOrCreate.bind(this));
      } else if (this.digit === 1) {
        this.showBlue();
      }
    } else if (target.classList.contains("plus")) {
      this.digitEl.innerText = ++this.digit;
      this.debounced(this.updateOrCreate.bind(this));
    }
  }

  debounced(f, timeout = 300) {
    let debounced = debounce(f, timeout);
    debounced(this.dto());
  }
}
