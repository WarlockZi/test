import "./like.scss";
import { $ } from "@src/common.js";
import Table from "@components/table/Table.js";
import MyCardPanels from "@src/Modules/admin/card_panel/MyCardPanels.js";
import { qa } from "@src/constants.js";
import shippableTable from "@components/shippable/shippableTable.js";

export default class Like {
  constructor() {
    // debugger;
    this.like = $(".likes-page").first();
    if (!this.like) return false;

    // const table = new Table(this.like);
    // table.setDelUrl("/like/del");
    new MyCardPanels();
    this.mapShippableTables();
  }

  mapShippableTables() {
    const sh = this.like[qa](".shippable-table");
    [...this.like[qa](".shippable-table")].forEach((table) => {
      new shippableTable(table);
    });
  }
}
