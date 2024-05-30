import './check_mark.scss'
import './modal.scss'
import {$, createElement} from '../../common'

export default class Modal {

  constructor(props) {
    this.modal = $(`[data-modal='default']`).first();
    if (!this.modal) return;
    if (!props.button) return;

    this.button = props.button;
    this.data = props.data;
    this.callback = props.callback;

    this.fieldsObj = {};

    this.closeEl = $(this.modal).find('.modal-close');
    this.title = $(this.modal).find('.title');
    this.box = $(this.modal).find('.modal-box');
    this.content = $(this.modal).find('.content');
    this.footer = $(this.modal).find('.footer');
    this.overlay = $(this.modal).find('.overlay');

    this.check = $('.checkmark').first();

    this.button.addEventListener('click', this.show.bind(this));
    this.closeEl.addEventListener('click', this.close.bind(this));
    this.overlay.addEventListener('click', this.close.bind(this));
  }

  async show() {
    this.$submit = (new createElement()).tag('div').attr('type', 'submit').attr('class', 'button').attr('id', 'submit').text(this.data.submitText).get();
    this.$submit.addEventListener('click', this.submit.bind(this));
    this.content.innerHTML = '';
    this.renderTitle();
    this.renderFields();
    this.renderContent();
    this.renderFooter();
    this.renderSubmitText();

    this.modal.style.display = 'flex';
    setTimeout(function () {
      this.overlay.style.opacity = 1;
      this.box.style.opacity = 1;
      this.box.classList.remove('transform-out');
      this.box.classList.add('transform-in')
    }.bind(this), 1)
  }

  async renderFields() {
    let fields = this.data.fields;
    for (let field in fields) {
      this.fieldsObj[field] = fields[field].querySelector('input');
      this.content.appendChild(fields[field])
    }
  }

  async renderContent() {
    for (let line in this.data.content) {
      this.content.appendChild(this.data.content[line])
    }
  }

  async renderFooter() {
    for (let line in this.data.footer) {
      this.footer.appendChild(this.data.footer[line])
    }
    this.footer.appendChild(this.$submit)
  }

  renderTitle() {
    this.title.innerText = this.data.title ?? 'Заголовок';
  }

  renderSubmitText() {
    this.$submit.innerText = this.data.submitText ?? 'ok';
  }

  async submit() {
    this.callback(this.fieldsObj, this);
  }

  close() {
    this.box.classList.remove('transform-in');
    this.box.classList.add('transform-out');
    this.overlay.style.opacity = 0;
    this.box.style.opacity = 0;
    setTimeout(function () {
      this.modal.style.display = 'none';
      this.footer.innerHTML = '';
    }.bind(this), 500)
  }

}