export default class Callbacks {
  constructor(table) {
    this.table = table;
    this.disableBaseRow();
  }

  disableBaseRow() {
    const rows = this.table.getRows();
    for (let i = 1; i < Object.keys(rows).length; i++) {
      let key = Object.keys(rows)[i];
      const row = rows[key];
      const from1sCell = this.getCell(row, "from_1s");
      if (!from1sCell.innerText) continue;
      if (from1sCell) {
        const selector = this.getSelectorCell(row);
        const multiplier = this.getCell(row, "multiplier");
        const multiplier_1 = this.getCell(row, "multiplier_1");
        const del = this.getDelCell(row);
        selector.setAttribute("disabled", "true");

        multiplier.setAttribute("contenteditable", "false");
        multiplier.setAttribute("disabled", "true");
        multiplier.innerText = "";

        multiplier_1.setAttribute("contenteditable", "false");
        multiplier_1.innerText = "";

        del.setAttribute("disabled", "true");
      }
    }
  }

  getSelectorCell(row) {
    const wrap = row.find((cell) => cell.querySelector("[select-new]"));
    return wrap.querySelector("[select-new]");
  }
  getDelCell(row) {
    return row.find((cell) => cell.classList.contains("del"));
  }
  getCell(row, field) {
    return row.find((cell) => cell?.dataset?.pivot === field);
  }
}
