import { checkboxSelector, searchSelector } from "../../../constants.js";
import { $ } from "@src/common.js";

export default class Callbacks {
  constructor(table) {
    this.table = table;
    this.disableBaseUnitRow();
    // this.deleteUsedSelects();
  }
  deleteUsedSelects() {
    const res = this.table.removeUsedSelectOptions();
    const rows = this.table.getRows();
    for (let i = 1; i < Object.keys(rows).length; i++) {
      const key = Object.keys(rows)[i];
      const cells = rows[key];
      const unitId = this.getFrom1sCell(cells, "unit_id");
      if (unitId) continue;
    }
  }
  disableBaseUnitRow() {
    const rows = this.table.getRows();
    for (let i = 1; i < Object.keys(rows).length; i++) {
      const key = Object.keys(rows)[i];
      const cells = rows[key];
      const from1sCell = this.getFrom1sCell(cells, "from_1s");
      if (from1sCell && !from1sCell.innerText) continue;
      if (from1sCell) {
        this.setFrom1sCellsDisabled(cells);
      }
    }
  }
  setFrom1sCellsDisabled(cells) {
    [].forEach.call(cells, (cell) => {
      cell.setAttribute("disabled", "");
      const unitSelector = cell.querySelector(`[` + searchSelector + `]`);
      const isShippableCheckbox = $(cell).find(`[` + checkboxSelector + `]`);
      const dividerCell = $(cell).find(`[data-pivot='divider']`);
      const multiplierCell = $(cell).find(`[data-pivot='multiplier']`);
      if (unitSelector) {
        unitSelector.setAttribute("disabled", "");
      }
      if (isShippableCheckbox) {
        isShippableCheckbox.setAttribute("disabled", "");
      }
      if (dividerCell) {
        dividerCell.setAttribute("contenteditable", "false");
        dividerCell.innerText = "";
      }
      if (multiplierCell) {
        multiplierCell.setAttribute("contenteditable", "false");
        multiplierCell.innerText = "";
      }
    });
  }

  getFrom1sCell(row, field) {
    return row.find((cell) => cell?.dataset?.field === field);
  }
}
