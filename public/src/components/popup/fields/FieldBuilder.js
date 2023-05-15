export default class FieldBuilder {
  constructor(tag='input') {
    this.el = document.createElement(tag);
    this.el.type = 'text'
  }

  class(name) {
    this.el.classList.add(name);
    return this
  }

  placeholder(str) {
    this.el.placeholder = str;
    return this
  }

  name(name) {
    this.el.name = name;
    return this
  }

  value(value) {
    this.el.value = value;
    return this
  }

  required() {
    this.el.required = true;
    return this
  }

  hidden() {
    this.el.hidder = true;
    return this
  }

  type(type) {
    this.el.type = type;
    return this
  }

  pattern(pattern) {
    this.el.pattern = pattern;
    return this
  }
  error(error) {
    this.el.error = error;
    return this
  }
}
