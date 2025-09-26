import { ael, qs } from "@src/constants.js";
import { post } from "../../common.js";

export default class adminPanel {
  constructor() {
    this.panel = document[qs](".admin-panel");
    this.panel[ael]("click", this.handleClick.bind(this));
  }

  async handleClick(e) {
    if (e.target.id === "cache-clear") {
      e.preventDefault();
      await post("/adminsc/cache/clear", {});
    }
  }
}
