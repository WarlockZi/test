class Checkboxes {
  constructor() {
    debugger
    // this.init()
    return this
  }

  init(container, field, value) {
    this.container = container
    this.field = field
    this.value = value
  }
}

export default function checkboxes() {
  return new Checkboxes()
}