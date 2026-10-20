import { post } from "@src/common.js";

export default class Clear_cache {
  constructor(HTMLElement) {
    HTMLElement.addEventListener("click", this.clear);
  }

  async clear(e) {
    e.preventDefault();
    const res = await post("/adminsc/cache/clear", {});
  }
}
