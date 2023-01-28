import {$} from '../../common'
class Checkboxes {
  constructor(container, field, value) {

    this.container = $(container).first()
    this.field = this.container.dataset.field
    this.value = this.container.dataset.value
    // this.init()
    return this
  }

  onChange(callback) {
    debugger
    callback().bind(this)

  }
}

export default function checkboxes(container, field, value) {
  return new Checkboxes(container, field, value)
}