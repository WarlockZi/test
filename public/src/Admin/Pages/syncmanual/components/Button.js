import Component from "@src/Admin/Pages/syncmanual/components/Component.js";
import { ael } from "@src/constants.js";

export default class Button extends Component {
  constructor(props) {
    super(props);
    this.element = props.element;
    this.onClick = props.onClick;
    this.isLoading = props.isLoading || false;
    this.isDisabled = props.isDisabled || false;

    this.init();
  }

  init() {
    this.updateVisualState();
    this.element[ael]("click", (e) => {
      if (!this.isDisabled && !this.isLoading && this.onClick) {
        this.onClick(e);
      }
    });
  }

  updateVisualState() {
    if (this.isLoading) {
      this.element.classList.add("btn--loading");
    } else {
      this.element.classList.remove("btn--loading");
    }

    if (this.isDisabled) {
      this.element.classList.add("disabled");
    } else {
      this.element.classList.remove("disabled");
    }
  }

  setLoading(loading) {
    this.isLoading = loading;
    this.updateVisualState();
  }

  setDisabled(disabled) {
    this.isDisabled = disabled;
    this.updateVisualState();
  }
}
