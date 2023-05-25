export default class InputContainer {
  constructor(settings) {
    const {
      _type,
      _className,
      _hidden,
      _required,
      _name,
      _autocomplete,
      _pattern,
      _badgeWidth,
      _id,
      _placeholder,
      _errorEl,
    } = settings;

    this.container = document.createElement('div');
    this.container.classList.add('input-container');

    this.input = document.createElement('input');
    if (_type) this.input.type = _type;
    this.input.placeholder = ' ';
    if (_className) this.input.classList.add(_className);
    if (_hidden) this.input.hidden = _hidden;
    if (_required) this.input.required = _required;
    debugger;
    if (_autocomplete) this.input.autocomplete = _autocomplete;
    if (_name) this.input.name = _name;
    if (_pattern) this.input.pattern = _pattern;
    this.input.id = _id;

    this.labelBadge = document.createElement('div');
    this.labelBadge.classList.add('badge');
    this.labelBadge.style.width = _badgeWidth;

    this.label = document.createElement('label');
    this.label.innerText = _placeholder;
    this.label.htmlFor = _id;

    this.container.append(this.input);
    this.container.append(this.labelBadge);
    this.container.append(this.label);
    if (_errorEl) this.container.append(_errorEl);
    return this.container
  }
}