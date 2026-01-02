import { $ } from "../../common.js";

export default class adminScroll {
  constructor() {
    this.adminPanel = $(".admin-panel").first();
    if (!this.adminPanel) return false;

    document.addEventListener("scroll", this.handle.bind(this), {
      passive: true,
    });
  }
  handle() {
    if (this.adminPanel)
      window.scrollY > 40
        ? this.adminPanel.classList.add("fixed")
        : this.adminPanel.classList.remove("fixed");
  }
}
