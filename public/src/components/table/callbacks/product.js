import { $, post } from "@src/common.js";

export default class Callbacks {
  async changeunit(target, table, detail) {
    const prev = detail.prev;
    const next = detail.next;
    const cells = table.getRowCells(prev);
    const url = `/adminsc/${table.model}/changeunit`;

    // setSelectId(next);
    setCellsId(cells, next);

    const dto = setDto(detail);
    const res = await post(url, dto);

    function setDto() {
      const dto = {};
      dto.id = $("[data-sid]").first()?.dataset?.sid;
      dto.prevUnitId = detail?.prev;
      dto.nextUnitId = detail?.next;
      return dto;
    }

    function setSelectId(next) {
      const cellWrapper = target.closest("[data-id]");
      cellWrapper.dataset.id = next;
    }

    function setCellsId(cells, next) {
      [].forEach.call(cells, (cell) => (cell.dataset.id = next));
    }
  }

  changemultiplier(target, table) {
    const rows = table.getRows();
    const perUnitPrice = getPerUnitPrice(rows, target);

    function recalculatePrices() {
      rows.forEach(
        (row, unitId) => {
          if (unitId === 0) return; //this is empty row

          const from1sCell = table.getCellByDataField(row, "from_1s");
          if (from1sCell.innerText) return;

          const multiplierCell = table.getCellByDataField(row, "divider");
          const multiplier_1Cell = table.getCellByDataField(row, "multiplier");
          const priceCell = table.getCellByDataField(row, "price");

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
        const from1sCell = table.getCellByDataField(row, "from_1s");
        if (from1sCell.innerText) {
          const from1sPriceCell = table.getCellByDataField(row, "price");
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
        const from1sCell = table.getCellByDataField(rows[key], "from_1s");
        if (from1sCell.innerText) continue;

        const priceCell = table.getCellByDataField(rows[key], "price");
        const dividerCell = table.getCellByDataField(rows[key], "divider");
        const multiplierCell = table.getCellByDataField(
          rows[key],
          "multiplier",
        );

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
