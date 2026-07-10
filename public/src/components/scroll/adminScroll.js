import { $ } from "../../common.js";

export default class adminScroll {
  constructor() {
    this.adminPanel = $(".admin-panel").first();
    if (!this.adminPanel) return false;

    this.header = document.querySelector(".admin-layout_header");
    this.lastScrollTop = 0;
    this.ticking = false;

    document.addEventListener("scroll", this.handleScroll.bind(this), {
      passive: true,
    });
  }
  // handle() {
  //   if (!this.ticking) {
  //     window.requestAnimationFrame(handleScroll);
  //   }
  //   window.scrollY > 40
  //     ? this.adminPanel.classList.add("fixed")
  //     : this.adminPanel.classList.remove("fixed");
  // }
  handleScroll() {
    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    const headerHeight = this.header.offsetHeight;

    if (scrollTop > headerHeight) {
      this.header.classList.add("visible");
    } else {
      this.header.classList.remove("visible");
    }

    this.lastScrollTop = scrollTop;
    this.ticking = false;
  }
}
