import {post, debounce, getToken} from "../common";
import Cookie from "../components/cookie/new/cookie";

export default function toCart({target}) {

  let cart = {
    cart: this,
    count: document.querySelector('.utils .cart .count'),
    adjust: this.querySelector('.adjust'),
    blue: this.querySelector('.blue'),
    digitEl: this.querySelector('.digit'),
    digit: +this.querySelector('.digit').innerText,
    product: this.closest('.product-card').dataset.id,

    showBlue: function () {
      this.blue.classList.remove('none');
      this.adjust.classList.add('none');
      // this.count.innerText = --this.count.innerText
    },

    showGreen: function () {
      this.blue.classList.add('none');
      this.adjust.classList.remove('none');
      // this.count.style.display = 'flex';
      // this.count.innerText = ++this.count.innerText;
      let obj = this.dto();
      this.debounced(this.send.bind(obj))
    },

    send: async function (obj) {
      let res = await post('/adminsc/OrderItem/updateOrCreate', obj);
      console.log(res)
    },

    debounced: function (f) {
      let debounced = debounce(f, 300);
      let obj = this.dto();
      debounced(obj)
    },

    dto: function () {
      return {
        id: 0,
        sess: getToken(),
        product_id: this.product,
        count: this.digit
      }
    }

  };

  cart.digitEl.onkeydown = function (e) {
    if (isNaN(+e.key) && e.key !== 'Backspace')
      e.preventDefault()
  };
  cart.digitEl.onchange = function (e) {

  };

  if (target.classList.contains('blue')) {
    cart.showGreen()

  } else if (target.classList.contains('minus')) {
    if (cart.digit > 1) {
      cart.digitEl.innerText = --cart.digit;
      // cart.count.innerText = cart.digit;
      let obj = cart.dto();
      cart.debounced(cart.send.bind(obj))
    } else if (cart.digit === 1) {
      cart.showBlue()
    }

  } else if (target.classList.contains('plus')) {
    cart.digitEl.innerText = ++cart.digit;
    // cart.count.innerText = cart.digit;
    let obj = cart.dto();
    cart.debounced(cart.send.bind(obj))
  }


}

