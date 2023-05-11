import './check_mark.scss'
import './popup.scss'
import Cart from '../Cart/cart'
import {$, createEl, post} from '../common'

export default function popup() {
  let popupShow = $('.popup-container .popup-show').first();
  if (!popupShow) return false;
  let popup = {
    show: popupShow,
    close: $('.popup-close').first(),
    wrapper: $('.popup-wrapper').first(),
    box: $('.popup-box').first(),
    overlay: $('.overlay').first(),
    submit: $('.popup-box #submit').first(),
    cart: $('.user-content .cart').first(),
    check: $('.checkmark').first(),
  };

  popup.show.addEventListener('click', show.bind(popup));
  popup.close.addEventListener('click', close.bind(popup));
  popup.overlay.addEventListener('click', close.bind(popup));
  popup.submit.addEventListener('click', submit.bind(popup));


  async function submit() {
    let form = {
      mobile: $(`.popup-box [name='tel']`).first().value,
      name: $(`.popup-box [name='fio']`).first().value,
      company: $(`.popup-box [name='company']`).first().value,
    };
    let cart = new Cart();
    let rows = cart.getRows();

    let data = {form,rows};

    close();
    let res = await post('/adminsc/orderItem/toorder', data);
    if (res.arr.ok) {
      showSuccess()
    }

  }

  function showSuccess() {
    let clone = popup.check.cloneNode(true);
    popup.cart.style.transition = 'all 1s';
    popup.cart.opacity = 0;
    popup.cart.minHeight = '100%';
    popup.cart.innerHTML = '';

    popup.cart.appendChild(clone);
    clone.style.display = 'block';

    let div = createEl('div',
      'message',
      `Вашу заявку оператор сможет найти по номеру вашего телефона - ${form.tel}`);
    popup.cart.appendChild(div)
  }

  function show() {
    // debugger
    popup.wrapper.style.display = 'flex';
    setTimeout(function () {
      popup.overlay.style.opacity = 1;
      popup.box.style.opacity = 1;
      popup.box.classList.remove('transform-out');
      popup.box.classList.add('transform-in')
    }, 1)
  }

  function close() {
    popup.box.classList.remove('transform-in');
    popup.box.classList.add('transform-out');
    popup.overlay.style.opacity = 0;
    popup.box.style.opacity = 0;
    setTimeout(function () {
      popup.wrapper.style.display = 'none'
    }, 800)
  }
}