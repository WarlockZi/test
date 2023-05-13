import './check_mark.scss'
import './popup.scss'
import Cart from '../../Cart/cart'
import {$, createEl, post} from '../../common'

export default class Popup {

  constructor() {
    let popupShow = $('.popup-wrapper').first();
    if (!popupShow) return false;

    this.showEl     = popupShow;
    this.closeEl    = $('.popup-close').first();
    this.wrapper    = $('.popup-wrapper').first();
    this.box        = $('.popup-box').first();
    this.overlay    = $('.overlay').first();
    this.submitEl   = $(`.popup-box #submit`).first();
    this.cart       = $('.user-content .cart').first();
    this.check      = $('.checkmark').first();

    this.showEl.addEventListener('click', this.show.bind(this));
    this.closeEl.addEventListener('click', this.close.bind(this));
    this.overlay.addEventListener('click', this.close.bind(this));
    this.submitEl.addEventListener('click', this.submit.bind(this));
  }

  async fillForm(name) {
    // return  await import(name)
  }

  async submit({target}) {
    // this.dto()
    let form = {
      mobile: $(`.popup-box [name='tel']`).first().value,
      name: $(`.popup-box [name='fio']`).first().value,
      company: $(`.popup-box [name='company']`).first().value,
    };
    let cart = new Cart();
    let rows = cart.getRows();

    let data = {form, rows};

    close();
    let res = await post('/adminsc/orderItem/toorder', data);
    if (res.arr.ok) {
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

  show(name) {
    debugger;
    // let items = this.fillForm(name);
    this.wrapper.style.display = 'flex';
    setTimeout(function () {
      this.overlay.style.opacity = 1;
      this.box.style.opacity = 1;
      this.box.classList.remove('transform-out');
      this.box.classList.add('transform-in')
    }.bind(this), 1)
  }

  close() {
    this.box.classList.remove('transform-in');
    this.box.classList.add('transform-out');
    this.overlay.style.opacity = 0;
    this.box.style.opacity = 0;
    setTimeout(function () {
      this.wrapper.style.display = 'none'
    }.bind(this), 800)
  }

}