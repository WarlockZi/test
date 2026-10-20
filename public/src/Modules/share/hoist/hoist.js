import "./hoist.scss";

export default class Hoist {
  constructor(el) {
    if (!el) {
      console.warn(`selector ${el} not found`);
      return false;
    }
    this.el = el;
    this.init();
  }
  init() {
    this.el.addEventListener("click", this.scrollToTop.bind(this));
  }
  scrollToTop() {
    const htmlBugOffset = 4;
    const current =
      document.documentElement.scrollTop - htmlBugOffset ||
      document.body.scrollTop;
    if (current > 0) {
      window.requestAnimationFrame(() => this.scrollToTop());
      window.scrollTo({ top: current - current / 9 });
    }
  }
}
