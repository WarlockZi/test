// import Select from "./select.js"
//
// const selectElements = document.querySelectorAll("[data-custom]")
//
// selectElements.forEach(selectElement => {
//   new Select(selectElement)
// })
import './WDSSelect.scss'

export default class WDSSelect {
  constructor(props) {
    this.element = props.element
    this.title = props.title
    this.options = getFormattedOptions(this.element.querySelectorAll("option"))
    this.customElement = document.createElement("div")
    this.customElement.classList.add(props.class)
    this.labelElement = document.createElement("span")
    this.titleElement = document.createElement("div")
    this.optionsCustomElement = document.createElement("ul")
    // this.selectedOption= this.element.selectedOptions[0]
    setupCustomElement(this)
    this.element.style.display = "none"
    this.element.after(this.customElement)
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

    this.labelElement.innerText = newSelectedOption.label
    this.optionsCustomElement
      .querySelector(`[data-value="${prevSelectedOption.value}"]`)
      .classList.remove("selected")
    const newCustomElement = this.optionsCustomElement.querySelector(
      `[data-value="${newSelectedOption.value}"]`
    )
    newCustomElement.classList.add("selected")
    newCustomElement.scrollIntoView({ block: "nearest" })
  }
}

function setupCustomElement(select) {
  select.customElement.classList.add("custom-select-container")
  // select.customElement.classList.add(select.element.dataset.customPath)
  select.customElement.tabIndex = 0

  select.titleElement.classList.add("custom-select-title")
  select.titleElement.innerText = select.title
  select.customElement.append(select.titleElement)
  // debugger
  select.labelElement.classList.add("custom-select-value")
  select.labelElement.innerText = select.selectedOption.label
  select.customElement.append(select.labelElement)

  select.optionsCustomElement.classList.add("custom-select-options")
  // setOption(getEmptyOption())
  select.options.forEach(option => {
    setOption(option)
  })

  function setOption(option){
    const optionElement = document.createElement("li")
    // debugger
    optionElement.classList.add("custom-select-option")
    optionElement.classList.toggle("selected", option.selected)
    optionElement.innerText = option.label
    optionElement.dataset.value = option.value
    // if(option.selected){
    //   select.selectValue(option.value)
    //   select.optionsCustomElement.classList.remove("show")
    //
    // }
    optionElement.addEventListener("click", () => {
      select.selectValue(option.value)
      select.optionsCustomElement.classList.remove("show")
    })
    select.optionsCustomElement.append(optionElement)
  }

  select.customElement.append(select.optionsCustomElement)

  select.labelElement.addEventListener("click", () => {
    select.optionsCustomElement.classList.toggle("show")
  })

  select.customElement.addEventListener("blur", () => {
    select.optionsCustomElement.classList.remove("show")
  })

  let debounceTimeout
  let searchTerm = ""
  select.customElement.addEventListener("keydown", e => {
    switch (e.code) {
      case "Space":
        select.optionsCustomElement.classList.toggle("show")
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
        select.optionsCustomElement.classList.remove("show")
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

function getEmptyOption() {
    return {
      value: 0,
      label: '',
      selected: false,
      element: ()=>document.createElement('li'),
    }
}
function getFormattedOptions(optionElements) {
  return [...optionElements].map(optionElement => {
    return {
      value: optionElement.value,
      label: optionElement.label,
      selected: optionElement.selected,
      element: optionElement,
    }
  })
}