import {$} from "@src/common.js";
import Table from "@src/components/table/Table.js";

export default class Tables {
   constructor() {
      debugger
      const tables = $('[custom-table]');
      if (tables) {
         [].forEach.call(tables, function (table) {
            new Table(table)
         })
      }
   }
}