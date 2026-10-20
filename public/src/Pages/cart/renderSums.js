import { it, qa, qs } from "@src/constants.js";
import { formatter } from "@src/common.js";

export default function renderSums(props) {
  const shTables = props.shippable_tables;
  const total = [...shTables].reduce((acc, table) => {
    // const price = +table.dataset.price;
    const sum = [...table[qa]("[unit-row]")].reduce(function (acc, unitRow, i) {
      const price = +unitRow[qs]("input").value;
      const count = +unitRow[qs]("[data-cost]").dataset.cost;
      const sum = price * count;

      const productRow = unitRow.closest(".row");
      const subSumEl = productRow[qs](".sub-sum");
      const rowSums = subSumEl[qa](".row-sum");
      const currentRowSum = rowSums[i];

      currentRowSum.innerText = sum ? formatter.format(sum) : "";

      return acc + sum;
    }, 0);
    return acc + sum;
  }, 0);
  props.total[it] = formatter.format(total);
}