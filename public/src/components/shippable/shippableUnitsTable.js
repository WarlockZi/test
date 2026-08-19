import { post } from "../../common";
import { ael, qa, qs } from "../../constants";

export default class shippableTable {
  constructor(table) {
    if (!table) return false;

    this.table = table;
    this.table[ael]("click", this.handleClick.bind(this));

    this.greenButtonWrap = this.table[qs](".green-button-wrap") ?? null;

    this.price = +this.table.dataset.price;
    this.sid = this.table.dataset["1sid"];
    this.total = this.table[qs]("[data-total]");
    this.updateOrCreateUrl = this.table[qs]("[data-total]");
    this.setFormatter();
    this.renderSums();
  }

  handleClick({ target }) {
    const targ = target ?? this.table;
    if (targ.classList.contains("to-cart-button")) {
      window.location.href = "/cart";
    } else if (targ.classList.contains("plus")) {
      const row = targ.closest(".unit-row");
      this.increment(row);
    } else if (targ.classList.contains("minus")) {
      const row = targ.closest(".unit-row");
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

  handleChange(row) {
    const count = this.getTotalCount(row);
    if (count === 1) {
      window.YM("tovar_v_korzine");
    }
    debugger;
    this.renderSums();
    this.toServer(this.dto(row));
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

  deleteOrderItems(tableDTO) {
    post(`/cart/delete`, tableDTO);
  }

  async toServer(dto) {
    const res = await post(`/cart/updateOrCreateCustom`, dto);
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

  tableDTO(table) {
    return {
      unit_ids: this.unitIds(table),
      product_id: this.sid,
    };
  }

  unitIds(table) {
    return [...table[qa]("[unit-row]")].map((unitRow) => {
      return unitRow.dataset.unitid;
    });
  }

  dto(row) {
    return {
      count: row[qs]("input").value,
      product_1s_id: row.closest("[data-product_1s_id]").dataset.product_1s_id,
      unit_id: row.dataset.unit_id,
      vitex_guest_id: localStorage.getItem("vitex_guest_id"),
    };
  }
}
