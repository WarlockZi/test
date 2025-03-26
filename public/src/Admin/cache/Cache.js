import { $, post } from "../../common.js";

export default class Cache {
  constructor() {
    debugger;
    this.linkCacheClear = $("#cache-clear").first();
    this.linkCacheClear.addEventListener("click", this.clear);
  }

  async clear(e) {
    e.preventDefault();
    const res = await post("/adminsc/cache/clear", {});
  }
}
