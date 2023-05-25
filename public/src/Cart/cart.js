// import './cart.scss'
import '../components/counter/counter'
import {$, cookieRemove, getToken, post, time} from '../common'
import Counter from "../components/counter/counter";
import Cookie from "../components/cookie/new/cookie";
import Modal from "../components/Modal/modal";
import CartSuccess from "../components/Modal/modals/CartSuccess";
import CartLogin from "../components/Modal/modals/CartLogin";
import CartLead from "../components/Modal/modals/CartLead";

export default class Cart {
  constructor() {
    let container = $('.user-content .cart .content').first();
    if (!container) return;
    this.container = container;
    this.model = $(this.container).find('[data-model]').dataset.model;

    new Modal({
      button: $('#cartLead').first(),
      data: new CartLead(),
      callback: this.modalLeadCallback.bind(this)
    });

    new Modal({
      button: $('#cartLogin').first(),
      data: new CartLogin(),
      callback: this.modalLoginCallback.bind(this)
    });

    new Modal({
      button: $('#cartSuccess').first(),
      data: new CartSuccess(),
      callback: this.modalcartSuccessCallback.bind(this)
    });

    this.total = container.querySelector('.total span');
    this.$cartEmptyText = document.querySelector('.empty-cart');

    this.rows = container.querySelectorAll('.row');
    this.container.onclick = this.handleClick.bind(this);
    this.container.onchange = this.rerenderSums.bind(this);

    this.cookie = new Cookie();
    this.counterEl = $('#counter').first();
    this.cartLifeMs = time.mMs * 30;
    if (this.counterEl) this.counterStart();

    this.rerenderSums()
  }


  async modalLeadCallback(fields, modal) {
    let name = fields.name.value;
    let phone = fields.phone.value;
    let company = fields.company.value;
    let sess = getToken();
    let res = await post('/cart/lead', {name, phone, company, sess});
    modal.close();
    if (res) {
      location.reload()
    }
  }

  async modalcartSuccessCallback(inputs, modal) {
    modal.close()
  }

  async modalLoginCallback(fields, modal) {
    let email = fields.email.value;
    let password = fields.password.value;
    let sess = getToken();
    let res = await post('/cart/login', {email, password, sess});
    modal.close();
    if (res) {
      location.reload()
    }
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
      this.showEmptyCart()
    }
  }

  orderItemDTO(target) {
    let row = target.closest('.row');
    return {
      sess: getToken(),
      product_id: row.dataset.productId
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
    let res = await post(`/adminsc/${this.model}/delete`, {...orderItemDto});
    if (res?.arr?.ok) {
      target.closest('.row').remove();
      if (this.countRows() < 1) this.showEmptyCart()
    }
  }

  countRows(){
    return document.querySelectorAll('.row').length
  }

  showEmptyCart() {
    this.container.innerHTML = '';
    this.$cartEmptyText.classList.remove('none')
  }

  async updateOItem(target) {
    let product_id = target.closest('.row').dataset.productId;
    let count = target.value;
    let sess = getToken();

    let res = await post(`/adminsc/orderItem/updateOrCreate`, {sess, product_id, count});

  }


}