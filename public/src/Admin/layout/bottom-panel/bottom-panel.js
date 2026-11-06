export default class BottomPanel {
  constructor() {
    this.wrapper = document.getElementById("panelWrapper");
    if (!this.wrapper) return;

    this.trigger = this.wrapper.querySelector(".hover-trigger");
    this.panel = this.wrapper.querySelector(".bottom-panel");
    this.pin = this.wrapper.querySelector('input.pin');

    this.trigger.addEventListener("mouseenter", this.openPanel.bind(this));
    this.trigger.addEventListener("mouseleave", this.closePanel.bind(this));

    this.panel.addEventListener("mouseleave", this.closePanel.bind(this));
  }

  openPanel() {
    this.wrapper.classList.add("active");
  }

  closePanel(e) {
    if (this.pin.checked) return;

    if (
      e.relatedTarget !== this.panel &&
      !this.panel.contains(e.relatedTarget)
    ) {
      this.wrapper.classList.remove("active");
    }
  }
}
