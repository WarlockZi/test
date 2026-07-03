import { searchSelector } from "../../../constants.js";

export default class Callbacks {
  constructor(table) {
    this.table = table;
    this.disableBaseUnitRow();
  }

  disableBaseUnitRow() {
    const rows = this.table.getRows();
    for (let i = 1; i < Object.keys(rows).length; i++) {
      const key = Object.keys(rows)[i];
      const row = rows[key];
      const from1sCell = this.getCell(row, "from_1s");
      if (from1sCell && !from1sCell.innerText) continue;
      if (from1sCell) {
        this.setSelectorCell(row);
        this.setDividerCell(row);
        this.setMultiplierCell(row);
      }
    }
  }

  setSelectorCell(row) {
    const selector = this.getSelectorCell(row);
    selector.setAttribute("disabled", "true");
  }

  setDividerCell(row) {
    const divider = this.getCell(row, "divider");
    divider.setAttribute("contenteditable", "false");
    divider.setAttribute("disabled", "true");
    divider.innerText = "";
  }

  setMultiplierCell(row) {
    const multiplier = this.getCell(row, "multiplier");
    multiplier.setAttribute("contenteditable", "false");
    multiplier.innerText = "";
  }

  getSelectorCell(row) {
    const selectorCell = row.find((cell) =>
      cell.querySelector(`[` + searchSelector + `]`),
    );
    return selectorCell.querySelector(`[` + searchSelector + `]`);
  }

  getDelCell(row) {
    return row.find((cell) => cell.classList.contains("del"));
  }

  getCell(row, field) {
    return row.find((cell) => cell?.dataset?.pivot === field);
  }
}
