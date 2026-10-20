import { $ } from "@src/common.js";

export default class Header_slider {
  constructor(header) {
    this.header = header;
    this.headerBottom = header.offsetTop + header.offsetHeight;

    const info = $(".info").first();
    this.infoBottom = info.offsetTop + info.offsetHeight;

    this.prevScrollpos = window.pageYOffset;

    window.onscroll = this.scroll.bind(this);
  }
  scroll() {
    const currentScrollPos = window.pageYOffset;
    if (
      this.prevScrollpos > currentScrollPos ||
      currentScrollPos < this.headerBottom
    ) {
      this.header.style.top = "0";
    } else {
      this.header.style.top = -1 * this.infoBottom + "px";
    }
    this.prevScrollpos = currentScrollPos;
  }
}
