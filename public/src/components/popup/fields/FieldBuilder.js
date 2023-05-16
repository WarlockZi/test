export default class FieldBuilder {
  constructor(id) {
    this.container = document.createElement('div');
    this.container.classList.add('input-container');

    this.el = document.createElement('input');
    this.el.type = 'text';
    this.el.placeholder = ' ';
    this.el.id = id;

    this.labelBadge = document.createElement('div');
    this.labelBadge.classList.add('badge');

    this.label = document.createElement('label');
    this.label.htmlFor  = id

  }

  class(name) {
    this.el.classList.add(name);
    return this
  }

  placeholder(placeholder) {
    this.label.innerText = placeholder;
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
    // let regex = pattern;
    let reg = new RegExp(pattern);
    this.el.setAttribute("pattern", reg.source);
    return this
  }

  badgeWidth(width) {
    this.labelBadge.style.width = width;
    return this
  }

  error(error) {
    this.errorEl = document.createElement('div');
    this.errorEl.innerText = error;
    return this
  }

  make() {
    // debugger
    this.container.append(this.el);
    this.container.append(this.labelBadge);
    this.container.append(this.label);
    if (this.errorEl) this.container.append(this.errorEl);
    return this.container
  }


}
