import {post, debounce} from "../common";

export default function toCart({target}) {

  let cart = {
    cart: this,
    adjust: this.querySelector('.adjust'),
    blue: this.querySelector('.blue'),
    digitEl: this.querySelector('.digit'),
    digit: +this.querySelector('.digit').innerText,
    product: +this.closest('.product-card').dataset.id,

    showBlue: function () {
      this.blue.classList.remove('none');
      this.adjust.classList.add('none')
    },

    showGreen: function () {
      this.blue.classList.add('none');
      this.adjust.classList.remove('none');

      debounce(this.send, 900)
    },

    send: function () {
      debugger;
      let res = post('/order/create', this)
    },

  };

  cart.digitEl.onkeydown = function (e) {
    if (isNaN(+e.key) && e.key !== 'Backspace')
      e.preventDefault()
  };

  if (target.classList.contains('blue')) {
    cart.showGreen()
  } else if (target.classList.contains('minus')) {
    if (cart.digit > 1) {
      cart.digitEl.innerText = --cart.digit
    } else if (cart.digit === 1) {
      cart.showBlue()
    }

  } else if (target.classList.contains('plus')) {
    cart.digitEl.innerText = ++cart.digit
  }


}

