import './cart.scss'
import '../components/counter/counter'
import {$, getCookie, getToken, cookieRemove, post} from '../common'
import Counter from "../components/counter/counter";

export default class Cart {
  constructor() {
    let container = $('.user-content .cart').first();
    if (!container) return;
    this.container = container;

    this.counterEl = $('#counter').first();

    this.counter = new Counter();
    this.counter.start();
    debugger;
    this.counter.showCounter(this.counterEl);

    this.rows = container.querySelectorAll('.row');
    this.container.onclick = this.handleClick;

    this.counterStart.call(this)
  }

  cartRemove(){

  }

  counterStart() {
    if (!this.counter.dif) {
      this.cartRemove()
    } else {
      this.counter.showCounter(this.counterEl)
    }

    let end = getCookie('cart');
    this.counter.setEnd(end);
    let res = this.duration();
    setInterval(function () {
      this.counter.innerText = --res;
      if (res === 0) this.dropCart()
    }.bind(this), 1000)
  }

  duration() {
    this.counter.getFormattedDiff()
    // cookieRemove('cart')
  }


  // async dropCart() {
  //   this.counter.remove();
  //   let cartToken = getToken();
  //   let res = await post('/cart/drop', {cartToken});
  //   if (res?.arr?.ok) {
  //     debugger;
  //     this.container.innerHTML = 'Корзина пуста'
  //   }
  //
  // }

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