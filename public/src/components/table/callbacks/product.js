import { post } from "@src/common.js";

function getCell(row, field) {
  return row.find((cell) => cell?.dataset?.pivot === field);
}

export default class Callbacks {
  changeunit(detail, rows) {
    const select = detail.el;
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

          const multiplierCell = getCell(row, "divider");
          const multiplier_1Cell = getCell(row, "multiplier");
          const priceCell = getCell(row, "price");

          const divider = multiplierCell ? multiplierCell.innerText : null;
          const multiplier = multiplier_1Cell ? multiplierCell.innerText : null;
          if (divider || multiplier) {
            priceCell.innerText = divider * perUnitPrice;
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

    function eatherDividerOrMultiplier(target, multiplierCell, dividerCell) {
      if (dividerCell?.innerText && multiplierCell?.innerText) {
        if (target.dataset.pivot === "divider") {
          multiplierCell.innerText = "";
        } else if (target.dataset.pivot === "multiplier") {
          dividerCell.innerText = "";
        }
      }
    }

    function renderPrice(divider, multiplier, priceCell, from1sPrice) {
      let perUnitPrice;
      if (divider) {
        perUnitPrice = from1sPrice / divider;
        priceCell.innerText = perUnitPrice;
      } else if (multiplier) {
        perUnitPrice = from1sPrice * multiplier;
        priceCell.innerText = perUnitPrice;
      } else {
        perUnitPrice = from1sPrice;
      }
      return perUnitPrice;
    }

    function getPerUnitPrice(rows, target) {
      if (Object.keys(rows).length < 2) return;
      const from1sPrice = getPriceFrom1s(rows);
      const productId = getProductId(target);

      for (let i = 1; i < Object.keys(rows).length; i++) {
        let key = Object.keys(rows)[i];
        const from1sCell = getCell(rows[key], "from_1s");
        if (from1sCell.innerText) continue;

        const priceCell = getCell(rows[key], "price");
        const dividerCell = getCell(rows[key], "divider");
        const multiplierCell = getCell(rows[key], "multiplier");

        eatherDividerOrMultiplier(target, multiplierCell, dividerCell);

        const divider = dividerCell?.innerText ?? null;
        const multiplier = multiplierCell?.innerText ?? null;
        const perUnitPrice = renderPrice(
          divider,
          multiplier,
          priceCell,
          from1sPrice,
        );

        productUnitUpdate(
          +productId,
          +key,
          dividerCell.innerText,
          multiplierCell.innerText,
          +perUnitPrice,
        );
      }
    }

    function productUnitUpdate(productId, unitId, divider, multiplier, price) {
      divider = divider ? divider : null;
      multiplier = multiplier ? multiplier : null;
      const dto = {
        productId,
        unitId,
        divider,
        multiplier,
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
