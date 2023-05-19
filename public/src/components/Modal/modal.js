import './check_mark.scss'
import './modal.scss'
import {$, createEl} from '../../common'

export default class Modal {

  constructor(props) {
    this.modal = $(`[data-modal='default']`).first();
    if (!this.modal) return;
    if (!props.button) return;

    this.closeEl = $(this.modal).find('.modal-close');
    this.title = $(this.modal).find('.title');
    this.box = $(this.modal).find('.modal-box');
    this.content = $(this.modal).find('.content');
    this.footer = $(this.modal).find('.footer');
    this.overlay = $(this.modal).find('.overlay');
    this.submitEl = $(this.modal).find(`#submit`);

    this.button = props.button;
    this.data = props.data;
    this.callback = props.callback;

    this.check = $('.checkmark').first();

    this.button.addEventListener('click', this.show.bind(this));
    this.closeEl.addEventListener('click', this.close.bind(this));
    this.overlay.addEventListener('click', this.close.bind(this));
    this.submitEl.addEventListener('click', this.submit.bind(this));
  }

  async show() {
    this.content.innerHTML = '';
    this.renderTitle();
    this.renderContent();
    this.renderFields();
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
    this.data.fields.forEach((field) => {
      this.content.appendChild(field)
    })
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
  }

  renderTitle() {
    this.title.innerText = this.data.title ?? 'Заголовок';
  }

  renderSubmitText() {
    this.submitEl.innerText = this.data.submitText ?? 'ok';
  }


  async submit({target}) {
    let success = this.callback(this.content.querySelectorAll('input'));
    // close();
    // let res = await post('/adminsc/orderItem/toorder', data);
    // if (res.arr.ok) {
    //   this.showSuccess()
    // }
    if (success) {
      debugger;
      this.showSuccess()
    }
  }

  showSuccess() {
    let clone = this.check.cloneNode(true);
    this.cart.style.transition = 'all 1s';
    this.cart.opacity = 0;
    this.cart.minHeight = '100%';
    this.cart.innerHTML = '';

    this.cart.appendChild(clone);
    clone.style.display = 'block';

    let div = createEl('div',
      'message',
      `Вашу заявку оператор сможет найти по номеру вашего телефона - ${form.tel}`);
    this.cart.appendChild(div)
  }


  close() {
    this.box.classList.remove('transform-in');
    this.box.classList.add('transform-out');
    this.overlay.style.opacity = 0;
    this.box.style.opacity = 0;
    setTimeout(function () {
      this.modal.style.display = 'none'
    }.bind(this), 800)
  }

}