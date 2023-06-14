import InputContainer from "./InputContainer";

export default class FieldBuilder {
  constructor(props) {
    this._type = 'text';
    this._required = false;
    this._badgeWidth = '50px';
    this._id = 'name';
    this._placeholder = 'email';
    this._autocomplete = false
  }

  id(id) {
    this._id = id;
    return this
  }
  type(type) {
    this._type = type;
    return this
  }
  hidden() {
    this._hidden = true;
    return this
  }
  required() {
    this._required = true;
    return this
  }
  name(name) {
    this._name = name;
    return this
  }
  autocomplete() {
    this._autocomplete = true;
    return this
  }
  placeholder(placeholder) {
    this._placeholder = placeholder;
    return this
  }

  class(value) {
    this._class = value;
    return this
  }
  pattern(pattern) {
    let reg = new RegExp(pattern);
    this._pattern = reg.source;
    return this
  }
  badgeWidth(width) {
    this._badgeWidth = width;
    return this
  }
  errorEl(errorEl) {
    this._errorEl = errorEl;
    return this
  }

  get() {
    return new InputContainer(this)
  }

}
