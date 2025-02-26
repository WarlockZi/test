import {createElement} from "../../../common.js";

export default class InputContainer {
   constructor(settings) {
      const {
         _type,
         _onKeyUp,
         _onInput,
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

      this.container = (new createElement).tag('div').attr('class', 'input-container').get();

      this.input = document.createElement('input');
      if (_onKeyUp) this.input.addEventListener('keyup', _onKeyUp.bind(this));
      if (_onInput) this.input.addEventListener('input', _onInput.bind(this));
      if (_type) {
         this.input.type = _type;
         if (_type === 'password') {
            this.showPass()
         }

      }
      this.input.placeholder = ' ';
      if (_className) this.input.classList.add(_className);
      if (_hidden) this.input.hidden = _hidden;
      if (_required) this.input.required = _required;

      if (_autocomplete) this.input.autocomplete = _autocomplete;
      if (_name) this.input.name = _name;
      if (_pattern) this.input.pattern = _pattern;
      this.input.id = _id;

      this.labelBadge = (new createElement).tag('div').attr('class', 'badge').get();
      this.labelBadge.style.width = _badgeWidth;

      this.label = (new createElement).tag('label').text(_placeholder).get();
      this.label.htmlFor = _id;

      this.container.append(this.input);
      this.container.append(this.labelBadge);
      this.container.append(this.label);

      if (_errorEl) {
         this.errorEl = (new createElement).tag('div')
         if (_errorEl.startsWith('#')) {
            const id = _errorEl.replace('#', '')
            this.errorEl = this.errorEl.attr('id', id)

         } else if (_errorEl.startsWith('.')) {
            const className = _errorEl.replace('.', '')
            this.errorEl = this.errorEl.attr('class', className)
         }
         this.errorEl = this.errorEl.get()
         this.container.append(this.errorEl);
      }

      return this.container
   }

   showPass() {
      const showPass = (new createElement).tag('span').attr('class', 'password-control').get()
      showPass.addEventListener('click', function ({target}) {
         target.parentNode.querySelector('input').type = target.parentNode.querySelector('input').type === 'password' ? 'text' : 'password'
         target.classList.toggle('view')
      });
      this.container.append(showPass)
   }


}