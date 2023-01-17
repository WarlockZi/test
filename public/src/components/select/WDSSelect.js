import './WDSSelect.scss'
import './customSelect.scss'
import {post} from "../../common";

export default class WDSSelect {

  constructor(el) {
    // debugger
    if (!el) return
    if (el.multiple) return

    this.title = el.title ?? ''
    this.field = el.dataset.field
    this.model = el.closest('.item_wrap').dataset.model
    this.modelId = el.closest('.item_wrap').dataset.id

    this.options = getFormattedOptions(el.querySelectorAll("option"))

    this.sel = document.createElement("div")
    this.sel.setAttribute("custom-select", '')
    debugger
    if (el.dataset.morphedModel) {
      this.sel.dataset.morphedModel = el.dataset.morphedModel
      this.sel.dataset.morphSlug = el.dataset.morphSlug ?? ''
      this.sel.dataset.morphDetach = el.dataset.morphDetach ?? ''
      this.sel.dataset.morphOneormany = el.dataset.morphOneormany ?? ''
    }
    if (el.dataset.model) {
      this.sel.dataset.model = el.dataset.model
      this.sel.dataset.id = el.dataset.modelId
    }
    if (el.dataset.field) {
      this.sel.dataset.field = el.dataset.field
    }

    if (el.className) this.sel.classList.add(el.className)

    this.label = document.createElement("span")
    this.arrow = document.createElement("div")
    this.space = document.createElement("div")

    this.ul = document.createElement("ul")
    setup(this)
    el.after(this.sel)
    // el.style.display = "none"
    el.remove()
  }

  get selectedOption() {
    return this.options.find(option => option.selected)
  }

  get selectedOptionIndex() {
    return this.options.indexOf(this.selectedOption)
  }

  selectValue(value) {
    // debugger
    const next = this.options.find(option => {
      return option.value === value
    })
    const prev = this.selectedOption
    prev.selected = false

    next.selected = true

    this.space.innerText = next.label
    // this.label.closest('[custom-select]').dataset['id'] = next.value
    this.label.closest('[custom-select]').dataset['value'] = next.value
    this.ul
      .querySelector(`[data-value="${prev.value}"]`)
      .classList.remove("selected")
    const newCustomElement = this.ul.querySelector(
      `[data-value="${next.value}"]`
    )
    newCustomElement.classList.add("selected")
    newCustomElement.scrollIntoView({block: "nearest"})
  }
}

function setup(select) {

  if (select.title) {
    select.titleElement = document.createElement("div")
    select.titleElement.classList.add("title")
    select.titleElement.innerText = select.title
    select.sel.append(select.titleElement)
  }

  if (select.field) {
    select.sel.dataset['field'] = select.field
  }
  select.sel.dataset['value'] = select.selectedOption.value
  select.sel.tabIndex = 0

  select.sel.append(select.label)

  select.space.classList.add("space")
  select.space.innerText = select.selectedOption.label
  select.label.append(select.space)

  select.arrow.classList.add("arrow")
  select.label.append(select.arrow)

  select.ul.classList.add("options")
  select.options.forEach(option => {
    setOption(option)
  })

  function getMorph(sel) {
    return {
      morph: {
        model: sel.dataset.morphModel,
        id: sel.dataset.morphId
      },
      morphed: {
        model: sel.dataset.morphedModel,
        id: sel.value,
        slug: sel.dataset.slug,
        oneOrMany: sel.dataset.oneOrMany,
        detach: sel.dataset.detach,
      }
    }
  }


  async function sendToServer(target) {
    let sel = target.closest('[custom-select]')
    if (sel.dataset.morphModel) {
      let data = getMorph(sel)
      let url = `/adminsc/${data.morph.model}/attachOne`
      let res = await post(url, data)
    }
    if (sel.dataset.field) {
      let id = target.closest('[data-model]').dataset.id
      let model = target.closest('[data-model]').dataset.model
      let data = {[sel.dataset.field]: sel.dataset.value,id}
      let url = `/adminsc/${model}/updateOrCreate`
      let res = await post(url, data)
    }
  }

  function setOption(option) {
    const li = document.createElement("li")
    li.innerText = option.label
    li.dataset.value = option.value
    li.classList.toggle("selected", option.selected)
    li.addEventListener("click", ({target}) => {
      select.selectValue(option.value)
      select.ul.classList.remove("show")
      sendToServer(target)
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