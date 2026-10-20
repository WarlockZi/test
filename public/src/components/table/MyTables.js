import { $ } from "../../common.js";

export default class MyTables {
  constructor() {
    this.table = $("[custom-table]").first();

    this.init();
  }
  async init() {
    if (this.table) {
      const { default: Table } = await import("./Table.js");
      // new Tables();

      const tables = $("[custom-table]");
      if (tables) {
        [].forEach.call(tables, function (table) {
          new Table(table);
        });
      }
    }
  }
}
