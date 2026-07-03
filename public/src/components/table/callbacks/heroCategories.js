import { post } from "@src/common.js";

function getCell(row, field) {
  return row.find((cell) => cell?.dataset?.pivot === field);
}

export default class Callbacks {
  changeCategory(detail, rows) {
    const select = detail.el;
    const cellWrapper = select.closest("[data-id]");
    const selectedValue = select.dataset.value;
    cellWrapper.dataset.id = selectedValue;
  }


}
