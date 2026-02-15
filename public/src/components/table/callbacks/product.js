import { post } from "@src/common.js";

function getCell(row, field) {
  return row.find((cell) => cell?.dataset?.pivot === field);
}

export default class Callbacks {
  changeunit(detail, rows) {
    const select = detail.target;
    const cellWrapper = select.closest("[data-id]");
    const selectedValue = select.dataset.value;
    cellWrapper.dataset.id = selectedValue;
  }

  changemultiplier(target, rows) {
    const perUnitPrice = getPerUnitPrice(rows, target);

    function recalculatePrices() {
      rows.forEach(
        (row, unitId) => {
          if (unitId === 0) return; //this is empty row

          const from1sCell = getCell(row, "from_1s");
          if (from1sCell.innerText) return; //this is price from 1s

          const multiplierCell = getCell(row, "multiplier");
          const multiplier_1Cell = getCell(row, "multiplier_1");
          const priceCell = getCell(row, "price");

          const multiplier = multiplierCell ? multiplierCell.innerText : null;
          const multiplier_1 = multiplier_1Cell
            ? multiplierCell.innerText
            : null;
          if (multiplier || multiplier_1) {
            priceCell.innerText = multiplier * perUnitPrice;
            productUnitUpdate(priceCell);
          }
        },
        [perUnitPrice],
      );
    }

    function getPriceFrom1s(rows) {
      for (let i = 1; i < Object.keys(rows).length; i++) {
        let key = Object.keys(rows)[i];
        const row = rows[key];
        const from1sCell = getCell(row, "from_1s");
        if (from1sCell.innerText) {
          const from1sPriceCell = getCell(row, "price");
          return +from1sPriceCell.innerText;
        }
      }
      return null;
    }

    function getProductId(target) {
      return (
        target?.closest(".item-wrap")?.dataset?.id ??
        target?.dataset?.id ??
        target?.parentNode?.dataset?.id
      );
    }

    function getPerUnitPrice(rows, target) {
      if (Object.keys(rows).length < 2) return;
      let perUnitPrice = 0;
      let from1sPrice = getPriceFrom1s(rows);
      const productId = getProductId(target);

      for (let i = 1; i < Object.keys(rows).length; i++) {
        let key = Object.keys(rows)[i];
        const from1sCell = getCell(rows[key], "from_1s");
        if (from1sCell.innerText) continue;

        const priceCell = getCell(rows[key], "price");

        const multiplierCell = getCell(rows[key], "multiplier");
        const multiplier_1Cell = getCell(rows[key], "multiplier_1");

        const multiplier = multiplierCell?.innerText ?? null;
        const multiplier_1 = multiplier_1Cell?.innerText ?? null;

        if (multiplier && multiplier_1) {
          if (target.dataset.pivot === "multiplier") {
            multiplier_1Cell.innerText = "";
          } else if (target.dataset.pivot === "multiplier_1") {
            multiplierCell.innerText = "";
          }
        }

        if (multiplier) {
          perUnitPrice = from1sPrice / multiplier;
          priceCell.innerText = perUnitPrice;
        } else if (multiplier_1) {
          perUnitPrice = from1sPrice * multiplier_1;
          priceCell.innerText = perUnitPrice;
        } else {
          perUnitPrice = from1sPrice;
        }
        productUnitUpdate(
          +productId,
          +key,
          +multiplierCell.innerText,
          +multiplier_1Cell.innerText,
          +perUnitPrice,
        );
      }
    }

    function productUnitUpdate(
      productId,
      unitId,
      multiplier,
      multiplier_1,
      price,
    ) {
      multiplier = multiplier ? multiplier : null;
      multiplier_1 = multiplier_1 ? multiplier_1 : null;
      const dto = {
        productId,
        unitId,
        multiplier,
        multiplier_1,
        price,
      };
      const res = post("/adminsc/product/changeunitprice", dto);
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
