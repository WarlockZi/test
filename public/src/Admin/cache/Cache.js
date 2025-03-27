import { $, post } from "../../common.js";

export default class Cache {
  constructor() {
    this.linkCacheClear = $("#cache-clear").first();
    this.linkCacheClear.addEventListener("click", this.clear);
  }

  async clear(e) {
    e.preventDefault();
    const res = await post("/adminsc/cache/clear", {});
  }
}
