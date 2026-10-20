import { $ } from "@src/common.js";

export default class MyDnds {
  constructor() {
    this.dnd = $("[dnd]");
    this.init();
  }
  async init() {
    if (this.dnd) {
      const { default: Dnds } = await import("@components/dnd/Dnds.js");
      new Dnds();
    }
  }
}
