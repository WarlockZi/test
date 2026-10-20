import { $, debounce, post } from "../../common";
import { ael, qa, qs } from "../../constants";

export default class shippableTable {
  constructor(table) {
    if (!table) return false;

    this.table = table;

    this.price = +this.table.dataset.price;
    this.rows = this.getRows();
    this.sid = this.table.closest("[data-product_1s_id]")?.dataset[
      "product_1s_id"
    ];
    this.total = this.table[qs]("[data-total]");
    this.updateOrCreateUrl = this.table[qs]("[data-total]");
    if (this.total) {
      this.renderSums();
    }
    this.setFormatter();
    // this.toServer = debounce(this.toServerRaw, 500);
    this.toServer = this.toServerRaw;
    this.table[ael]("click", this.handleClick.bind(this));
  }

  getRows() {
    return this.table[qa]("[unit-row]");
  }

  handleClick({ target }) {
    const targ = target ?? this.table;
    const row = targ.closest(".unit-row");

    if (targ.classList.contains("to-cart-button")) {
      window.location.href = "/cart";
    } else if (targ.classList.contains("plus")) {
      this.increment(row);
    } else if (targ.classList.contains("minus")) {
      this.decrement(row);
    }
  }

  increment(row) {
    row[qs]("input").value++;
    row.dataset.rowSum = "" + row[qs]("input").value;
    this.handleChange(row);
  }

  decrement(row) {
    const input = row[qs]("input");
    const count = +input.value;
    if (count < 2) {
      input.value = "0";
    } else {
      input.value--;
      row.dataset.rowSum = input.value;
    }
    this.handleChange(row);
  }

  getTotalCount() {
    return [...this.table[qa]("input")].reduce((acc, el) => {
      return acc + +el.value;
    }, 0);
  }

  async handleChange(row) {
    const count = this.getTotalCount(row);
    if (count === 1) {
      window.YM?.("tovar_v_korzine");
    }
    if (this.total) {
      this.renderSums();
    }
    const dto = this.dto(row);

    const res = await this.toServer(dto);
    if (res?.cart_count > 0) {
      this.updateCartBadge(res?.cart_count);
    }
  }
  updateCartBadge(cart_count) {
    const badge = $(".cart-link .count").first();
    if (!badge) return false;
    badge.innerText = cart_count;
  }

  async toServerRaw(order_item_dto) {
    return new Promise((resolve) => {
      debounce(async (dto) => {
        await post(`/cart/add`, dto).then(resolve);
      }, 300)(order_item_dto);
    });
  }
  renderSums() {
    let total = [...this.table[qa](".unit-row")].reduce((acc, row, i) => {
      const rowDto = this.rowDto(row);
      let sub_sum = +this.price * +rowDto.count;
      if (rowDto.sub_sum)
        rowDto.sub_sum.innerText = this.formatter.format(sub_sum);
      return acc + sub_sum;
    }, 0);

    if (this.total) {
      this.total.innerText = this.formatter.format(total);
    }
  }

  setFormatter() {
    this.formatter = new Intl.NumberFormat("ru", {
      style: "currency",
      currency: "RUB",
      minimumFractionDigits: 2,
    });
  }

  rowDto(row) {
    return {
      count: row[qs]("input").value ?? null,
      cost: row.dataset.cost ?? null,
      sub_sum: row[qs](".sub-sum") ?? null,
      sess_id: localStorage.getItem("SESSION"),
    };
  }

  dto(row) {
    return {
      product_1s_id: this.sid.trim(),
      count: row[qs]("input").value,
      unit_id: row.dataset.unit_id,
    };
  }
}
