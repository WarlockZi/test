import { post } from "@src/common.js";
import TableDTO from "@src/Admin/TableDTO.js";

export default class Callbacks {
  changeunit(detail, rows) {
    const select = detail.target;
    const cellWrapper = select.closest("[data-id]");
    const selectedValue = select.dataset.value;
    cellWrapper.dataset.id = selectedValue;
  }

  changemultiplier(target, rows) {
    const perUnitPrice = getPerUnitPrice(rows);
    if (!perUnitPrice) return;

    recalculatePrices();

    function recalculatePrices() {
      rows.forEach(
        (row, unitId) => {
          if (unitId === 0) return; //this is empty row

          const from1sCell = getCell(row, "from_1s");
          if (from1sCell.innerText) return; //this is price from 1s

          const multiplierCell = getCell(row, "multiplier");
          const priceCell = getCell(row, "price");

          const multiplier = multiplierCell ? multiplierCell.innerText : null;
          if (multiplier) {
            priceCell.innerText = multiplier * perUnitPrice;
            productUnitUpdate(priceCell);
          }
        },
        [perUnitPrice],
      );
    }

    function getPerUnitPrice(rows) {
      let perUnitPrice = 0;
      for (let i = 1; i < Object.keys(rows).length; i++) {
        let key = Object.keys(rows)[i];
        const from1sCell = getCell(rows[key], "from_1s");
        if (!from1sCell.innerText) continue;

        const multiplierCell = getCell(rows[key], "multiplier");
        const priceCell = getCell(rows[key], "price");

        const multiplier = multiplierCell?.innerText ?? null;
        if (!multiplier) return;

        const price = priceCell?.innerText ?? null;
        if (price) {
          perUnitPrice = price / multiplier;
          return perUnitPrice;
        }
      }
    }

    function getCell(row, field) {
      return row.find((cell) => cell?.dataset?.pivot === field);
    }

    function productUnitUpdate(target) {
      const dto = new TableDTO(target);
      const res = post("/adminsc/product/changeunitprice", dto);
    }
  }

  changeprice(target, rows, updateFn = null) {
    const targetPrice = target.innerText;
    const targetId = target.dataset.id;
    const targetMultiplier = getPrice(targetId);
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

    function getPrice(rowId) {
      const row = rows[rowId];
      const multiplierCell = row.find(
        (cell) => cell?.dataset?.pivot === "price",
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
