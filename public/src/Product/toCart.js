import {$, debounce, getToken, post} from "../common";

export default class toCart {
  constructor() {
    this.toCart = $('.to-cart').first();
    if (!this.toCart) return;
    this.count = document.querySelector('.utils .cart .count');
    this.adjust = this.toCart.querySelector('.adjust');
    this.blue = this.toCart.querySelector('.blue');
    this.digitEl = this.toCart.querySelector('.digit');
    this.digit = +this.toCart.querySelector('.digit').innerText;
    this.product = this.toCart.closest('.product-card').dataset.id;

    this.digitEl.onkeydown = debounce(this.keyDown.bind(this), 1300);
    this.toCart.onclick = this.handleClick.bind(this)
  }

  showBlue() {
    this.blue.classList.remove('none');
    this.adjust.classList.add('none');
    this.count.innerText = --this.count.innerText
  }

  showGreen() {
    this.blue.classList.add('none');
    this.adjust.classList.remove('none');
    this.count.innerText = ++this.count.innerText
  }

  async send() {
    let obj = this.dto();
    let res = await post('/adminsc/OrderItem/updateOrCreate', obj);
    console.log(res)
  }


  keyDown(e) {
    if (isNaN(+e.key) && e.key !== 'Backspace') {
      e.preventDefault()
    }
    this.send()
  }

  handleClick({target}) {

    if (target.classList.contains('blue')) {
      this.showGreen();
      this.debounced(this.send.bind(this))

    } else if (target.classList.contains('minus')) {
      if (this.digit > 1) {
        this.digitEl.innerText = --this.digit;
        this.debounced(this.send.bind(this))
      } else if (this.digit === 1) {
        this.showBlue()
      }
    } else if (target.classList.contains('plus')) {
      this.digitEl.innerText = ++this.digit;
      this.debounced(this.send.bind(this))
    }
  }

  debounced(f, timeout = 300) {
    let debounced = debounce(f, timeout);
    let obj = this.dto();
    debounced(obj)
  }

  dto() {
    return {
      id: 0,
      sess: getToken(),
      product_id: this.product,
      count: +this.digitEl.innerText
    }
  }
};









