import {post, debounce, getToken} from "../common";

export default function toCart({target}) {

  let cart = {
    cart: this,
    token: getToken(),
    count: document.querySelector('.utils .cart .count'),
    adjust: this.querySelector('.adjust'),
    blue: this.querySelector('.blue'),
    digitEl: this.querySelector('.digit'),
    digit: +this.querySelector('.digit').innerText,
    product: this.closest('.product-card').dataset.id,

    showBlue: function () {
      this.blue.classList.remove('none');
      this.adjust.classList.add('none');
      this.count.innerText = --this.count.innerText
    },

    showGreen: function () {
      this.blue.classList.add('none');
      this.adjust.classList.remove('none');
      this.count.style.display = 'flex';
      this.count.innerText = ++this.count.innerText;
      let debounced = debounce(this.send, 900);
      let obj = this.dto();
      // debugger;
      debounced(obj)
    },

    send: function (obj) {
      let res = post('/adminsc/orderItem/updateOrCreate', obj)
    },

    dto: function () {
      return {
        sess:this.token,
        product_id: this.product,
        count: this.digit
      }
    }

  };

  cart.digitEl.onkeydown = function (e) {
    if (isNaN(+e.key) && e.key !== 'Backspace')
      e.preventDefault()
  };

  if (target.classList.contains('blue')) {
    cart.showGreen()
  } else if (target.classList.contains('minus')) {
    if (cart.digit > 1) {
      cart.digitEl.innerText = --cart.digit;
      cart.count.innerText = cart.digit;
      let obj = this.dto();
      // debugger;
      cart.debounced(obj)
    } else if (cart.digit === 1) {
      cart.showBlue()
    }
  } else if (target.classList.contains('plus')) {
    cart.digitEl.innerText = ++cart.digit;
    cart.count.innerText = cart.digit
  }


}

