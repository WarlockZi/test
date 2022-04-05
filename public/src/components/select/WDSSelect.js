import './WDSSelect.scss'
import './customSelect.scss'
import {$} from "../../common";

export default class WDSSelect {

  constructor(props) {

    let el = $(`[custom-select][data-field='${props.field}']`)[0]
    if (!el) return false
    this.element = el

    this.title = this.element.dataset['title'] ?? ''
    this.field = props.field
    this.options = getFormattedOptions(this.element.querySelectorAll("option"))

    this.sel = document.createElement("div")
    this.sel.classList.add(props.class)

    this.label = document.createElement("span")

    this.ul = document.createElement("ul")
    setup(this)
    this.element.style.display = "none"
    this.element.after(this.sel)
  }

  get selectedOption() {
    return this.options.find(option => option.selected)
  }

  get selectedOptionIndex() {
    return this.options.indexOf(this.selectedOption)
  }

  selectValue(value) {
    const newSelectedOption = this.options.find(option => {
      return option.value === value
    })
    const prevSelectedOption = this.selectedOption
    prevSelectedOption.selected = false
    prevSelectedOption.element.selected = false

    newSelectedOption.selected = true
    newSelectedOption.element.selected = true

    this.label.innerText = newSelectedOption.label
    this.ul
      .querySelector(`[data-value="${prevSelectedOption.value}"]`)
      .classList.remove("selected")
    const newCustomElement = this.ul.querySelector(
      `[data-value="${newSelectedOption.value}"]`
    )
    newCustomElement.classList.add("selected")
    newCustomElement.scrollIntoView({block: "nearest"})
  }
}

function setup(select) {

  if (select.title) {
    select.titleElement = document.createElement("div")
    select.titleElement.classList.add("custom-select-title")
    select.titleElement.innerText = select.title
    select.sel.append(select.titleElement)
  }

  select.sel.classList.add("custom-select")
  select.sel.dataset['field'] = select.field
  select.sel.tabIndex = 0

  // debugger
  select.label.classList.add("custom-select-value")
  select.label.innerText = select.selectedOption.label
  select.sel.append(select.label)

  select.ul.classList.add("custom-select-options")
  select.options.forEach(option => {
    setOption(option)
  })

  function setOption(option) {
    const li = document.createElement("li")
    li.classList.add("custom-select-option")
    li.classList.toggle("selected", option.selected)
    li.innerText = option.label
    li.dataset.value = option.value
    li.addEventListener("click", () => {
      select.selectValue(option.value)
      select.ul.classList.remove("show")
    })
    select.ul.append(li)
  }

  select.sel.append(select.ul)

  select.label.addEventListener("click", () => {
    select.ul.classList.toggle("show")
  })

  select.sel.addEventListener("blur", () => {
    select.ul.classList.remove("show")
  })

  let debounceTimeout
  let searchTerm = ""
  select.sel.addEventListener("keydown", e => {
    switch (e.code) {
      case "Space":
        select.ul.classList.toggle("show")
        break
      case "ArrowUp": {
        const prevOption = select.options[select.selectedOptionIndex - 1]
        if (prevOption) {
          select.selectValue(prevOption.value)
        }
        break
      }
      case "ArrowDown": {
        const nextOption = select.options[select.selectedOptionIndex + 1]
        if (nextOption) {
          select.selectValue(nextOption.value)
        }
        break
      }
      case "Enter":
      case "Escape":
        select.ul.classList.remove("show")
        break
      default: {
        clearTimeout(debounceTimeout)
        searchTerm += e.key
        debounceTimeout = setTimeout(() => {
          searchTerm = ""
        }, 500)

        const searchedOption = select.options.find(option => {
          return option.label.toLowerCase().startsWith(searchTerm)
        })
        if (searchedOption) {
          select.selectValue(searchedOption.value)
        }
      }
    }
  })
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