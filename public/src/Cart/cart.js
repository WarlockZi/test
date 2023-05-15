import './cart.scss'
import '../components/counter/counter'
import {$, getCookie, time, getToken, cookieRemove, post} from '../common'
import Counter from "../components/counter/counter";
import Cookie from "../components/cookie/new/cookie";
import Popup from "../components/popup/popup";

export default class Cart {
  constructor() {
    let container = $('.user-content .cart .content').first();
    if (!container) return;
    this.container = container;

    this.popup = new Popup();

    this.total = container.querySelector('.total span');
    this.cartEmptyText = container.parentNode.querySelector('.empty-cart');

    this.cartLeadBtn = container.querySelector('#cartLead');
    this.cartLeadBtn.onclick = this.cartLead.bind(this);

    this.cartLoginBtn = container.querySelector('#cartLogin');
    this.cartLoginBtn.onclick = this.cartLead.bind(this);

    this.rows = container.querySelectorAll('.row');
    this.container.onclick = this.handleClick.bind(this);
    this.container.onchange = this.rerenderSums.bind(this);

    this.cookie = new Cookie();
    this.counterEl = $('#counter').first();

    this.cartLifeMs = time.mMs * 3;
    this.counterStart();

    this.rerenderSums()
  }

  rerenderSums() {
    if (!this.rows.length) return false;
    let total = [].reduce.call(this.rows, (acc, row, accd, rows) => {
      let price = row.querySelector('.price').dataset.price;
      let count = row.querySelector('.count').value;
      let sum = price * count;
      row.querySelector('.sum').innerText = sum.toFixed(2);
      acc += sum;
      return acc
    }, 0);
    let formatter = new Intl.NumberFormat("ru");
    this.total.innerText = formatter.format(total.toFixed(2))
  }

  counterStart() {
    let rows = $(this.container).find('.row');
    if (rows) {
      debugger;
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

  cartLogin() {
    // this.popup.show('cartLogin')
  }

  cartLead() {
    // this.popup.show('cartLead')
  }

  counterCallback() {
    this.nullifyCookie();
    this.dropCart()
  }

  nullifyCookie() {
    cookieRemove('cartDeadline')
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
      this.cartEmptyText.classList.remove('none');
      this.container.classList.add('none')
    }
  }

  orderItemDTO(target){
    let row = target.closest('.row');
    return {
      sess:getToken(),
      product_id:row.dataset.productId
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
    // debugger
    if (target.classList.contains('del')) {
      this.deleteOItem(target)
    } else if (target.classList.contains('count')) {
      this.rerenderSums();
      this.updateOItem(target)

    }
  }

  async deleteOItem(target) {
    let orderItemDto = this.orderItemDTO(target);

    let res = await post(`/adminsc/orderItem/delete`, {...orderItemDto});
    if (res?.arr?.ok) {
      row.remove()
    }
  }

  async updateOItem(target) {
    let product_id = target.closest('.row').dataset.productId;
    let count = target.value;
    let sess = getToken();

    let res = await post(`/adminsc/orderItem/updateOrCreate`, {sess, product_id, count});
    // if (res?.arr?.ok) {
    //   row.remove()
    // }
  }


}