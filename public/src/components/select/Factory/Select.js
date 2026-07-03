import { $ } from "@src/common.js";
import "../SearchableSelect.scss";
import { searchSelector } from "@src/constants.js";

export class Select {
  constructor(selectEl, config = {}) {
    if (typeof selectEl !== "object") {
      console.log("Переданный в select контейнер не тип object");
      return false;
    }
    if (selectEl.tagName.toLowerCase() !== "select") {
      console.log("Tag Переданный контейнер не тип select");
      return false;
    }

    this.selectEl = selectEl;
    this.elements = {};
    this.currentToPick = {};
    this._visibleOptions = [];

    this.options = config.options ?? $(this.selectEl).findAll("option");
    this.onSelect = config.onSelect || (() => {});
    this.isOpen = config?.isOpen || false;

    this.getSelectedOption();
    this.render();
    this.bindEvents();
  }

  dispatchEvent() {
    this.container.dispatchEvent(
      new CustomEvent("searchableSelect.changed", {
        bubbles: true,
        detail: {
          selectThis: this,
          el: this.container,
          prev: {
            value: 0,
          },
        },
      }),
    );
  }

  getSelectedOption() {
    const selectedOption = [].filter.call(
      this.options,
      (opt) => opt.selected,
    )[0];
    this.selectedValue = selectedOption ? selectedOption.value : null;
  }

  toggleSelectedOption(value) {
    const newOption = this.elements.optionElements.find(
      (optEl) => String(optEl.dataset.value) === String(value),
    );
    if (newOption) {
      newOption.setAttribute("selected", "true");
    }

    const oldOption = this.elements.optionElements.find((optEl) =>
      optEl.hasAttribute("selected"),
    );
    if (oldOption) {
      oldOption.removeAttribute("selected");
    }
  }

  select(value) {
    const option = [].find.call(
      this.options,
      (opt) => String(opt.value) === String(value),
    );
    if (!option) return;

    this.toggleSelectedOption(value);

    this.selectedValue = option.value;
    this.elements.trigger.textContent = option.label;
    this.elements.trigger.classList.add("is-selected");
    this.container.setAttribute("data-value", value);

    this.close();
    this.onSelect(option.value, option);
    this.dispatchEvent();
  }

  copyAttributes(source, target) {
    const attrs = source.attributes;
    for (let i = 0; i < attrs.length; i++) {
      const attr = attrs[i];
      attr.name === "class"
        ? target.classList.add(attr.value)
        : target.setAttribute(attr.name, attr.value);
    }
  }

  renderContainer() {
    this.container = document.createElement("div");

    this.container.setAttribute(searchSelector, "");
    this.container.classList.add("filterable-select");
    this.container.setAttribute("data-role", "select");
    this.copyAttributes(this.selectEl, this.container);
  }

  render() {
    this.renderContainer();

    this.elements.trigger = document.createElement("div");
    this.elements.trigger.className = "fs-trigger";
    this.elements.trigger.textContent = "Выберите значение";
    this.elements.trigger.setAttribute("tabindex", "0");
    this.elements.trigger.setAttribute("role", "button");
    this.elements.trigger.setAttribute("aria-haspopup", "listbox");
    this.elements.trigger.setAttribute("aria-expanded", "false");

    this.elements.dropdown = document.createElement("div");
    this.elements.dropdown.className = "fs-dropdown";

    this.elements.optionsList = document.createElement("ul");
    this.elements.optionsList.className = "fs-options";
    this.elements.optionsList.setAttribute("role", "listbox");

    this.elements.optionElements = [];
    [].forEach.call(this.options, (opt) => {
      const li = document.createElement("li");
      li.className = "fs-option";
      li.textContent = opt.label;
      li.dataset.value = opt.value;
      li.setAttribute("role", "option");
      if (this.selectedValue === opt.value) {
        this.select(opt.value);
        li.setAttribute("selected", "true");
      }
      this.elements.optionsList.appendChild(li);
      this.elements.optionElements.push(li);
    });

    this.elements.noResults = document.createElement("div");
    this.elements.noResults.className = "fs-no-results";
    this.elements.noResults.textContent = "Ничего не найдено";

    this.elements.dropdown.appendChild(this.elements.optionsList);
    this.elements.dropdown.appendChild(this.elements.noResults);

    this.container.append(this.elements.trigger);
    this.container.append(this.elements.dropdown);
    this.selectEl.after(this.container);
    this.selectEl.style.display = "none";
  }

  adjustPosition() {
    const triggerRect = this.elements.trigger.getBoundingClientRect();
    const dropdownHeight = this.elements.dropdown.offsetHeight;
    const viewportHeight = window.innerHeight;

    const spaceBelow = viewportHeight - triggerRect.bottom;
    const spaceAbove = triggerRect.top;

    this.elements.dropdown.style.top = "";
    this.elements.dropdown.style.bottom = "";

    if (spaceBelow < dropdownHeight && spaceAbove > dropdownHeight) {
      // Открываем вверх
      this.elements.dropdown.style.bottom = `calc(100% + 4px)`;
      this.elements.dropdown.style.top = "auto";
    } else {
      // Открываем вниз (по умолчанию)
      this.elements.dropdown.style.top = `calc(100% + 4px)`;
      this.elements.dropdown.style.bottom = "auto";
    }
  }

  bindEvents() {
    window.addEventListener("resize", () => this.adjustPosition());
    window.addEventListener("scroll", () => this.adjustPosition());
    document.addEventListener("click", (e) => {
      if (!this.container.contains(e.target)) this.close();
    });

    this.elements.trigger.addEventListener("click", () => this.toggle());
    this.elements.trigger.addEventListener("keydown", (e) => {
      if (e.key === "Enter" || e.key === " ") {
        e.preventDefault();
        this.toggle();
      }
    });

    this.elements.optionsList.addEventListener("click", (e) => {
      const option = e.target.closest(".fs-option");
      if (option) this.select(option.dataset.value);
    });
    this.elements.dropdown.addEventListener("keydown", (e) => {
      if (e.key === "ArrowDown") {
        this.nextPick();
      } else if (e.key === "ArrowUp") {
        this.previousPick();
      } else if (e.key === "Enter" || e.key === " ") {
        e.preventDefault();
        this.selectPicked();
      }
    });
  }
  selectPicked() {
    this.select(this.currentToPick.dataset.value);
    this.currentToPick.classList.toggle("to-pick");
  }

  nextPick() {
    let curtoPick = null;
    let nextToPick = null;
    let foundToPick = false;
    this._visibleOptions.forEach((option) => {
      if (!nextToPick && foundToPick) nextToPick = option;
      if (option.classList.contains("to-pick")) {
        curtoPick = option;
        foundToPick = true;
      }
    });
    if (curtoPick) {
      this.currentToPick.classList.toggle("to-pick");
      this.currentToPick = nextToPick;
      nextToPick.classList.toggle("to-pick");
    } else {
      this.currentToPick = this._visibleOptions[0];
      this.currentToPick.classList.toggle("to-pick");
    }
  }

  previousPick() {
    let currentPick = null;
    let prevToPick = null;
    let lastOption = null; // Для отслеживания последнего элемента

    this._visibleOptions.forEach((option) => {
      if (option.classList.contains("to-pick")) {
        currentPick = option;
      }

      lastOption = option;

      if (!currentPick) {
        prevToPick = option;
      }
    });

    if (currentPick) {
      this.currentToPick.classList.toggle("to-pick");
      this.currentToPick = prevToPick || currentPick; // fallback на currentPick если prevToPick null
      this.currentToPick.classList.toggle("to-pick");
    } else {
      this.currentToPick = this._visibleOptions[0];
      this.currentToPick.classList.toggle("to-pick");
    }
  }

  visibleOptions() {
    this._visibleOptions = [];
    this.elements.optionElements.filter((option, index) => {
      if (!option.classList.contains("none")) {
        this._visibleOptions.push(option);
      }
    });
  }
  toggle() {
    if (this.container.hasAttribute("disabled")) return false;
    this.isOpen ? this.close() : this.open();
  }

  open() {
    if (this.isOpen) return;
    this.isOpen = true;
    this.elements.dropdown.classList.add("is-open");
    this.elements.trigger.setAttribute("aria-expanded", "true");
    this.adjustPosition();
  }

  close() {
    if (!this.isOpen) return;
    this.isOpen = false;
    this.elements.dropdown.classList.remove("is-open");
    this.elements.trigger.setAttribute("aria-expanded", "false");
  }

  reset() {
    this.selectedValue = null;
    this.elements.trigger.textContent = "Выберите значение";
    this.elements.trigger.classList.remove("is-selected");
    this.close();
  }
}
