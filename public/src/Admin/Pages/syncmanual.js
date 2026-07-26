import Dnd from "@components/dnd/dnd.js";
import { $ } from "@src/common.js";
import Dnds from "@components/dnd/Dnds.js";

export default class syncmanual {
  constructor() {
    new Dnds();
    // this.setDND();
  }
  setDND() {
    const dnd = $("[dnd]").first();
    const cb = () => {};
    new Dnd(dnd);
  }
}
