import { ael, qs } from "@src/constants.js";
import { debounce } from "@src/common.js";

export default class Shippable_row {
  constructor(el) {
    this.el = el;
    this.unitId = el.dataset?.unit_id;

    this.input = this.el[qs]("input");

    this.plus = this.el[qs](".plus");
    this.minus = this.el[qs](".minus");
    this.boundDebounced = debounce(this._dispatchEvent.bind(this), 300);

    this.plus[ael]("click", this.increment.bind(this));
    this.minus[ael]("click", this.decrement.bind(this));

    this.input[ael]("click", this.handleClick.bind(this));
    this.input[ael]("focusout", this.handleFocusout.bind(this));
    this.input[ael]("keyup", this.handleKeyup.bind(this));
  }
  handleKeyup(e) {
    if (e.code === "Enter" || e.code === "NumpadEnter") {
      this.input.blur();
    } else if (
      e.code === "Backspace" ||
      e.code === "Delete" ||
      this.isDigit(e)
    ) {
      this.boundDebounced();
    }
  }
  increment() {
    this.input.value++;
    this.boundDebounced();
  }

  decrement() {
    if (this.input.value === 0) return;

    if (this.input.value === 1) {
      this.input.value = "0";
    } else {
      this.input.value--;
    }
    this.boundDebounced();
  }

  handleClick(e) {
    if (e.target === this.input) {
      if (e.target.value === "0") {
        e.target.value = "";
      }
    }
  }

  handleFocusout(e) {
    if (e.target.value === "") {
      e.target.value = "0";
    }
  }

  _dispatchEvent() {
    const event = new CustomEvent(`shippable.count.changed`, {
      bubbles: true,
      detail: {
        value: this.input.value,
        unit_id: this.unitId,
      },
    });
    this.input.dispatchEvent(event);
  }
  isDigit(e) {
    const isDigit = e.code.startsWith("Digit");
    const isNumpadDigit =
      e.code.startsWith("Numpad") &&
      ![
        "NumpadEnter",
        "NumpadDecimal",
        "NumpadAdd",
        "NumpadSubtract",
        "NumpadMultiply",
        "NumpadDivide",
      ].includes(e.code);

    return isDigit || isNumpadDigit;
  }
}
