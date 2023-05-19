export default class FieldBuilder {
  constructor(props) {
    this.a  =[]
  }

  // constructor() {
  //   this.container = document.createElement('div');
  //   this.container.classList.add('input-container');
  //
  //   this.el = document.createElement('input');
  //   this.el.type = 'text';
  //   this.el.placeholder = ' ';
  //
  //   this.labelBadge = document.createElement('div');
  //   this.labelBadge.classList.add('badge');
  //
  //   this.label = document.createElement('label');
  // }
  // class(name) {
  //   this.class = name;
  //   return this
  // }
  // placeholder(placeholder) {
  //   this.label.innerText = placeholder;
  //   return this
  // }
  // name(name) {
  //   this.el.name = name;
  //   return this
  // }
  // value(value) {
  //   this.el.value = value;
  //   return this
  // }
  // required() {
  //   this.el.required = true;
  //   return this
  // }
  // hidden() {
  //   this.hidden = true;
  //   return this
  // }
  // id(id) {
  //   this.htmlFor = id;
  //   return this
  // }
  // type(type) {
  //   this.type = type;
  //   return this
  // }
  // badgeWidth(width) {
  //   this.labelBadge.style.width = width;
  //   return this
  // }
  //
  // error(error) {
  //   this.errorEl = document.createElement('div');
  //   this.errorEl.innerText = error;
  //   return this
  // }
  set id(id) {
    this._id = id;
    return this
  }

  get id() {
    return this._id
  }

  set type(type) {
    this._type = type;
    return this
  }

  get type() {
    return this._type
  }

  set hidden(hidden) {
    this._hidden = hidden;
    return this
  }

  get hidden() {
    return this._hidden
  }

  set required(required) {
    this._required = true;
    return this
  }

  get required() {
    return this._required
  }

  set class(value) {
    this._class = value;
    return this
  }

  get class() {
    return this._class
  }

  set pattern(pattern) {
    let reg = new RegExp(pattern);
    // this.el.setAttribute("pattern", reg.source);
    this._pattern = reg.source;
    return this
  }

  get pattern() {
    return this._pattern
  }

  set badgeWidth(width) {
    this._badgeWidth = width;
    return this
  }

  get badgeWidth() {
    return this._badgeWidth
  }

  set htmlFor(htmlFor) {
    this._htmlFor = htmlFor;
    return this
  }

  get htmlFor() {
    return this._htmlFor
  }

  set errorEl(errorEl) {
    this._errorEl = errorEl;
    return this
  }

  get errorEl() {
    return this._errorEl
  }

  make() {
    this.container = document.createElement('div');
    this.container.classList.add('input-container');

    this.el = document.createElement('input');
    this.el.type = this.type ?? 'text';
    this.el.placeholder = ' ';
    this.el.classList.add(this.class);
    this.el.hidden = this.hidden ?? false;


    this.labelBadge = document.createElement('div');
    this.labelBadge.classList.add('badge');

    this.label = document.createElement('label');

    this.label.htmlFor = this.htmlFor ?? '';

    this.container.append(this.el);
    this.container.append(this.labelBadge);
    this.container.append(this.label);
    if (this.errorEl) this.container.append(this.errorEl);
    return this.container
  }


}
