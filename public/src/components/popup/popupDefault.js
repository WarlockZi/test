import './check_mark.scss'
import './popup.scss'
import Cart from '../../Cart/cart'
import {$, createEl, post} from '../../common'

export default class PopupDefault {

  constructor(props) {
    this.popup = $(`[data-popup='default']`).first();
    this.closeEl = $(this.popup).find('.popup-close');
    this.title = $(this.popup).find('.title');
    this.box = $(this.popup).find('.popup-box');
    this.form = $(this.popup).find('.form');
    this.overlay = $(this.popup).find('.overlay');
    this.submitEl = $(this.popup).find(`#submit`);

    this.button = props.button;
    this.data = props.data;
    this.callback = props.callback;

    if (!this.button) return;
    this.check = $('.checkmark').first();

    this.button.addEventListener('click', this.show.bind(this));
    this.closeEl.addEventListener('click', this.close.bind(this));
    this.overlay.addEventListener('click', this.close.bind(this));
    this.submitEl.addEventListener('click', this.submit.bind(this));
  }

  async renderFields() {
    this.form.innerHTML = '';
    this.title.innerText = this.data.title;
    for (let field in this.data.fields) {
      this.form.prepend(this.data.fields[field].el)
    }
  }

  async submit({target}) {

    let success = this.callback(this.form.querySelectorAll('input'));
    // let form = {
    //   mobile: $(`.popup-box [name='tel']`).first().value,
    //   name: $(`.popup-box [name='fio']`).first().value,
    //   company: $(`.popup-box [name='company']`).first().value,
    // };
    // let cart = new Cart();
    // let rows = cart.getRows();
    // let data = {form, rows};
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

  async show(name) {

    this.renderFields(name);

    this.popup.style.display = 'flex';
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
      this.popup.style.display = 'none'
    }.bind(this), 800)
  }

}