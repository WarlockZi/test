// import '../Auth/auth'
import './main.scss'
import popup from '../popup/popup'
import cart from '../Cart/cart'

import '../components/header/autocomplete'
// import '../Product/card'
import '../Category/category'

document.addEventListener('DOMContentLoaded',function () {
  // debugger
  popup();
  new cart()
});

