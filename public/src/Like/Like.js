import {$} from "@src/common.js";
import Table from "@src/components/table/Table.js";

export default class Like{
   constructor(){
      const like = $('[custom-table].likes').first()
      if (!like) return false

      const table = new Table(like)
   }
}