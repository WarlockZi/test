import Component from "@src/Admin/Pages/syncmanual/components/Component.js";

export default class NoFilesMessage extends Component {
  constructor(props) {
    super(props);
    this.element = props.element;
    this.isVisible = props.isVisible || false;

    this.init();
  }

  init() {
    this.updateVisibility();
  }

  updateVisibility() {
    if (this.isVisible) {
      this.element.classList.remove("slide-out");
      this.element.classList.add("slide-in");
    } else {
      this.element.classList.add("slide-out");
      this.element.classList.remove("slide-in");
    }
  }

  show() {
    this.isVisible = true;
    this.updateVisibility();
  }

  hide() {
    this.isVisible = false;
    this.updateVisibility();
  }
}
