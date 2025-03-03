import {$} from '../../common'

class Checkboxes {
  constructor(container, context) {
    this.container = $(container).first()
    if (!this.container)return null
    this.data = {}
    this.setContext(context)
    return this
  }

  getValue() {
    let values = [...$(`input[type='checkbox']`)]
      .filter((input,) => {
        return input.checked
      })
      .map((input) => {
        return input.dataset.id
      })


    if (values) return values.join(',')
  }

  setContext(ctx) {
    this.model = ctx.model
    this.data.id = ctx.id
    return this
  }

  onChange(callback) {
    // debugger
    if (!this.container) return
    this.container.onchange = function () {
      let value = this.getValue()
      this.container.dataset.value = value
      this.data[this.container.dataset.field] = value

      callback.call(this)
    }.bind(this)
  }
}

export default function checkboxes() {
  return new Checkboxes(...arguments)
}