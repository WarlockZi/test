import { $, newObjAndFiles2FormData, post } from "@src/common.js";
import Dnd from "@components/dnd/dnd.js";

export default class Dnds {
  constructor() {
    this.dnds = $("[dnd]");
    this.setDnds();
  }

  setDnds() {
    [].map.call(this.dnds, (dnd) => {
      new Dnd(dnd, this.prepareData);
    });
  }

  async prepareData(files, target) {
    if (!target?.dataset?.action) {
      console.log("Data-action attr is missing on dnd element");
      return false;
    }
    const url = target.dataset.action;
    const obj = {};
    const data = newObjAndFiles2FormData(obj, files[0]);

    const res = await post(url, data);
    if (res) {
      target.innerText = `zip`;
    }
  }
}
