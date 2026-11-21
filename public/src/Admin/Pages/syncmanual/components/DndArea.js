import Component from "@src/Admin/Pages/syncmanual/components/Component.js";
import { $ } from "@src/common.js";
import Dnd from "@components/dnd/dnd.js";

export default class DndArea extends Component {
  constructor(props) {
    super(props);
    this.element = props.element;
    this.onFilesDrop = props.onFilesDrop;
    this.isVisible = props.isVisible ?? true;

    this.init();
  }

  init() {
    this.updateVisibility();
    this.setupDnd();
  }

  updateVisibility() {
    if (this.isVisible) {
      this.element.classList.add("slide-in");
      this.element.classList.remove("slide-out");
    } else {
      this.element.classList.remove("slide-in");
      this.element.classList.add("slide-out");
    }
  }

  setupDnd() {
    const dnds = Array.from($("[dndfile]"));
    dnds.forEach((dnd) => {
      new Dnd(dnd, async (files) => {
        if (this.onFilesDrop) {
          await this.onFilesDrop(files, dnd);
        }
      });
    });
  }

  hide() {
    this.isVisible = false;
    this.updateVisibility();
  }

  show() {
    this.isVisible = true;
    this.updateVisibility();
  }
}
