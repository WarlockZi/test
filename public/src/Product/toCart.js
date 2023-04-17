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
      this.blue.classList.remove('none')
      this.adjust.classList.add('none')
    },
    send: function () {
      let res = post('/order/')

    }
  }

  if (target.classList.contains('button')) {
    cart.adjust.classList.toggle('none')
    cart.blue.classList.toggle('none')

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

