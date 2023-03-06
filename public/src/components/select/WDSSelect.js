import './WDSSelect.scss'
import '../del/customSelect.scss'
import {post} from "../../common";

export default class WDSSelect {

  constructor(el) {
    // debugger
    if (!el) return
    if (el.multiple) return

    this.title = el.title ?? ''
    this.field = el.dataset.field
    this.model = el.closest('.item_wrap')?.dataset.model
    this.modelId = el.closest('.item_wrap')?.dataset.id

    this.options = getFormattedOptions(el.querySelectorAll("option"))

    this.sel = document.createElement("div")
    this.sel.setAttribute("custom-select", '')
    // debugger
    if (el.dataset.morphFunction) {
      this.sel.dataset.morphFunction = el.dataset.morphFunction
      this.sel.dataset.morphSlug = el.dataset.morphSlug ?? ''
      this.sel.dataset.morphDetach = el.dataset.morphDetach ?? ''
      this.sel.dataset.morphOneormany = el.dataset.morphOneormany ?? ''
    }
    // debugger
    if (el.dataset.belongstoModel) {
      this.sel.dataset.belongstoModel = el.dataset.belongstoModel
      this.sel.dataset.belongstoId = el.dataset.belongstoId
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
    select.sel.dataset.field = select.field
  }
  select.sel.dataset.value = select.selectedOption.value
  select.sel.tabIndex = 0

  select.sel.append(select.label)

  select.space.classList.add("space")
  select.space.innerText = select.selectedOption.label
  select.label.append(select.space)

  select.arrow.classList.add("arrow")
  select.label.append(select.arrow)

  select.ul.classList.add("options")
  select.options.forEach(option => {
    // debugger
    setOption(option)
  })

  function getMorph(sel) {
    let item = sel.closest('.item_wrap')
    let morph = sel.parentNode
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

  async function sendToServer(target) {
    let sel = target.closest('[custom-select]')
    if (sel.parentNode.dataset.morphRelation) {
      let data = getMorph(sel)
      let url = `/adminsc/${data.morph.model}/attach`
      let res = await post(url, data)
    }
    if (sel.dataset.field) {
      let id = target.closest('.item_wrap').dataset.id
      let model = target.closest('[data-model]').dataset.model
      let data = {[sel.dataset.field]: sel.dataset.value, id}
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