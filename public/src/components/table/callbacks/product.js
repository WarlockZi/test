import { post } from "@src/common.js";
import TableDTO from "@src/Admin/TableDTO.js";

export default class Callbacks {
  changeunit(detail, cells) {
    const select = detail.target;
    const cellWrapper = select.closest("[data-id]");
  }

  changeprice(target, rows, updateFn = null) {
    const targetPrice = target.innerText;
    const targetId = target.dataset.id;
    const targetMultiplier = getMultiplier(targetId);
    if (!targetMultiplier) return;

    const unitPrice = targetPrice / targetMultiplier;

    rows.forEach(
      (row, unitId) => {
        if (unitId !== +targetId) {
          const multiplierCell = row.find(
            (cell) => cell?.dataset?.pivot === "multiplier",
          );
          const priceCell = row.find(
            (cell) => cell?.dataset?.pivot === "price",
          );

          const multiplier = multiplierCell ? multiplierCell.innerText : "";
          if (multiplier) {
            priceCell.innerText = multiplier * unitPrice;
            productUnitUpdate(priceCell);
          }
        }
      },
      [unitPrice],
    );

    function productUnitUpdate(target) {
      const dto = new TableDTO(target);
      const res = post("/adminsc/product/changeunitprice", dto);
    }

    function getMultiplier(rowId) {
      const row = rows[rowId];
      const multiplierCell = row.find(
        (cell) => cell?.dataset?.pivot === "multiplier",
      );
      return multiplierCell ? multiplierCell.innerText : "";
    }
  }

  callMethod(methodName, args) {
    if (typeof this[methodName] === "function") {
      this[methodName](...args);
    } else {
      console.log(`Method ${methodName} not found`);
    }
  }
}
