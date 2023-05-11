import './cart.scss'
import '../components/counter/counter'
import {$, getCookie, getToken, cookieRemove, post} from '../common'
import Counter from "../components/counter/counter";
import Cookie from "../components/cookie/new/cookie";

export default class Cart {
  constructor() {
    let container = $('.user-content .cart').first();
    if (!container) return;
    this.container = container;

    this.rows = container.querySelectorAll('.row');
    this.container.onclick = this.handleClick;

    this.cookie = new Cookie();
    this.counterEl = $('#counter').first();

    this.cartLifeMs = 1 * 1000 * 1_000_000;
    this.counterStart()
  }

  counterStart() {
    let rows = $(this.container).find('.row');
    if (rows) {
      let cartDeadline = +this.cookie.cookie.get_cookie('cartDeadline');
      let dif = cartDeadline - Date.now();
      if (dif >= 0) {
        this.cookie.cookie.set_cookie('cartDeadline', cartDeadline);
        this.counter = new Counter(this.counterEl, cartDeadline, this.counterCallback.bind(this))
      } else {
        let cartDeadline = this.getDeadline();
        this.cookie.cookie.set_cookie('cartDeadline', cartDeadline);
        this.counter = new Counter(this.counterEl, cartDeadline, this.counterCallback.bind(this))
      }
    } else {
      this.counterCallback()
    }
  }

  getDeadline() {
    return this.cartLifeMs + Date.now()
  }

  counterCallback() {
    // this.counterReset()
    this.nullifyCookie();
    this.dropCart()
  }

  nullifyCookie() {
    this.cookie.cookie.set_cookie('cartDeadline', -1)
  }

  counterReset() {
    let cartDeadline = this.getDeadline();
    this.cookie.cookie.set_cookie('cartDeadline', cartDeadline);
    if (this.counter) {
      this.counter.reset(cartDeadline)
    } else {
      this.counter = new Counter(this.counterEl, cartDeadline, this.counterCallback.bind(this));
    }
  }

  async dropCart() {
    let cartToken = getToken();
    let res = await post('/cart/drop', {cartToken});
    if (res?.arr?.ok) {
      // debugger
      this.container.innerHTML = 'Корзина пуста'
    }
  }

  getRows() {
    let rows = [].map.call(this.rows, (row) => {
      return {
        id: row.querySelector('.name').dataset['1sid'],
        count: row.querySelector('.count').value
      }
    });
    return rows
  }

  async handleClick({target}) {
    if (target.classList.contains('del')) {
      let row = target.closest('.row');
      let id = row.querySelector('.name').dataset['1sid'];

      let res = await post(`/adminsc/orderItem/delete`, {id});
      if (res.arr.ok) {
        row.remove()
      }

    } else if (target.classList.contains('d')) {

    }
  }

}