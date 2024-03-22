import './SelectNew.scss'

import {createElement, post} from "../../common";

export default class Select {

  constructor(el) {
    if (!el) return;

    this.options = getFormattedOptions(el.querySelectorAll("option"));

    this.sel = (new createElement())
      .tag("div")
      .className(el?.className)
      .field(el.dataset.field)
      .attr("select-new", '')
      .attr("data-value", this?.selectedOption?.value ?? '')
      .attr('tabindex', '0').get();

    el.after(this.sel);

    this.label = document.createElement("span");
    this.sel.append(this.label);

    this.space = (new createElement()).tag("div").attr('class', "space").text(this?.selectedOption?.label).get();
    this.label.append(this.space);

    this.arrow = (new createElement()).tag("div").attr('class', "arrow").get();
    this.label.append(this.arrow);

    this.ul = (new createElement()).tag("ul").attr('class', "options").get();

    this.options.forEach(option => {
      setOption(option, this)
    });

    this.sel.append(this.ul);

    this.label.onclick = () => this.ul.classList.toggle("show");
    this.sel.onblur = () => this.ul.classList.remove("show");
    this.sel.onkeydown = this.keyDownhandler;

    el.remove()
  }

  onchange(callback) {
    this.callback = callback
  }

  keyDownhandler(e) {
    let debounceTimeout;
    let searchTerm = "";

    if (e.code === "Space") {
      select.ul.classList.toggle("show");
    } else if (e.code === "ArrowUp") {
      const prevOption = select.options[select.selectedOptionIndex - 1];
      if (prevOption) {
        select.selectValue(prevOption.value)
      }
    } else if (e.code === "ArrowDown") {
      const nextOption = select.options[select.selectedOptionIndex + 1];
      if (nextOption) {
        select.selectValue(nextOption.value)
      }
    } else if (e.code === "Enter" || e.code === "Escape") {
      select.ul.classList.remove("show");
    } else {
      clearTimeout(debounceTimeout);
      searchTerm += e.key;
      debounceTimeout = setTimeout(() => {
        searchTerm = ""
      }, 500);
      const searchedOption = e.target.options.find(option => {
        return option.label.toLowerCase().startsWith(searchTerm)
      });
      if (searchedOption) {
        select.selectValue(searchedOption.value)
      }
    }
  }

  get selectedOption() {
    return this.options.find(option => option.selected)
  }

  get selectedOptionIndex() {
    return this.options.indexOf(this.selectedOption)
  }

  selectValue(value) {
    const next = this.options.find(option => {
      return option.value === value
    });
    const prev = this.selectedOption;

    prev.selected = false;
    next.selected = true;

    this.space.innerText = next.label;

    this.sel.dataset['value'] = next.value;
    prev.element.classList.remove('selected');

    next.element.classList.add('selected');
    next.element.scrollIntoView({block: "nearest"});

    this.sel.dispatchEvent(new CustomEvent('customSelect.changed', {
      bubbles: true,
      detail: {next, prev, target: this.sel}
    }));
    // if (this.callback) this.callback({next, prev, target: this.sel})
  }

}


function setOption(option, select) {
  const li = (new createElement()).tag("li").text(option.label).attr('data-value', option.value).get();

  if (option.selected) li.classList.add("selected");
  li.onclick = ({target}) => {
    select.selectValue(option.value);
    select.ul.classList.remove("show");
  };
  select.ul.append(li)
}

function getFormattedOptions(options) {
  return [...options].map(option => {
    return {
      value: option.value,
      label: option.label,
      selected: option.selected,
      element: option,
    }
  })
}

