import './WDSSelect.scss'
import '../del/customSelect.scss'
import {createElement, post} from "../../common";

export default class WDSSelect {

  constructor(el) {
    if (!el) return;
    if (el.multiple) return;

    this.title = el.title ?? '';
    this.field = el.dataset.field;
    this.model = el.closest('.item-wrap')?.dataset.model;
    this.modelId = el.closest('.item-wrap')?.dataset.id;

    this.options = getFormattedOptions(el.querySelectorAll("option"));

    this.sel = (new createElement()).tag("div").attr("custom-select", '').attr('class', el?.className).get();

    this.morphBelongField(this.sel, el);

    el.after(this.sel);

    setup(this);
    el.remove()
  }

  morphBelongField(sel, el) {
    if (el.dataset.morphFunction) {
      sel.dataset.morphFunction = el.dataset.morphFunction;
      sel.dataset.morphSlug = el.dataset.morphSlug ?? '';
      sel.dataset.morphDetach = el.dataset.morphDetach ?? '';
      sel.dataset.morphOneormany = el.dataset.morphOneormany ?? ''
    }

    if (el.dataset.belongstoModel) {
      sel.dataset.belongstoModel = el.dataset.belongstoModel;
      sel.dataset.belongstoId = el.dataset.belongstoId
    }
    if (el.dataset.field) {
      sel.dataset.field = el.dataset.field
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

    this.label.closest('[custom-select]').dataset['value'] = next.value;
    this.ul.querySelector(`.selected`).classList.remove("selected");
    const newCustomElement = this.ul.querySelector(
      `[data-value="${next.value}"]`
    );
    newCustomElement.classList.add("selected");
    newCustomElement.scrollIntoView({block: "nearest"});

    dispatchEvent(new CustomEvent('customSelect.changed', {
      bubbles: true,
      detail: {next, prev, target: this.sel}
    }))
  }
}

function setup(select) {

  if (select.title) {
    let titleElement = (new createElement()).tag("div").attr('class', 'title').text(select.title).get();
    select.sel.append(titleElement)
  }

  if (select.field) {
    select.sel.dataset.field = select.field
  }
  select.sel.dataset.value = select?.selectedOption?.value;
  select.sel.tabIndex = 0;

  select.label = document.createElement("span");
  select.sel.append(select.label);

  select.space = (new createElement()).tag("div").attr('class', "space").text(select?.selectedOption?.label).get();
  select.label.append(select.space);

  select.arrow = (new createElement()).tag("div").attr('class', "arrow").get();
  select.label.append(select.arrow);

  select.ul = (new createElement()).tag("ul").attr('class', "options").get();

  select.options.forEach(option => {
    setOption(option, select)
  });

  select.sel.append(select.ul);

  select.label.onclick = () => select.ul.classList.toggle("show");
  select.sel.onblur = () => select.ul.classList.remove("show");

  let debounceTimeout;
  let searchTerm = "";
  select.sel.addEventListener("keydown", e => {
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
      const searchedOption = select.options.find(option => {
        return option.label.toLowerCase().startsWith(searchTerm)
      });
      if (searchedOption) {
        select.selectValue(searchedOption.value)
      }
    }
  })
}

function setOption(option, select) {
  const li = (new createElement()).tag("li").text(option.label).attr('data-value', option.value).get();

  if (option.selected) li.classList.add("selected");
  li.onclick = ({target}) => {
    select.selectValue(option.value);
    select.ul.classList.remove("show");
    sendToServer(target)
  };
  select.ul.append(li)
}

async function sendToServer(target) {
  let sel = target.closest('[custom-select]');
  if (sel.parentNode.dataset.morphRelation) {
    let data = getMorph(sel);
    let url = `/adminsc/${data.morph.model}/attach`;
    let res = await post(url, data)
  }
  if (sel.dataset.field) {
    let id = target.closest('.item-wrap').dataset.id;
    let model = target.closest('[data-model]').dataset.model;
    let data = {[sel.dataset.field]: sel.dataset.value, id};
    let url = `/adminsc/${model}/updateOrCreate`;
    let res = await post(url, data)
  }
}

function getMorph(sel) {
  let item = sel.closest('.item-wrap');
  let morph = sel.parentNode;
  return {
    morph: {
      id: item.dataset.id,
      model: item.dataset.model,
    },
    morphed: {
      id: sel.dataset.value,
      relation: morph.dataset.morphRelation,
      slug: morph.dataset.morphSlug,
      oneOrMany: morph.dataset.morphOneormany,
    }
  }
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