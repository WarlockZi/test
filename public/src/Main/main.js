import '../404/404.scss'
import './main.scss'

import cart from '../Cart/cart'

import '../Category/category'
import {$} from "../common";
import Search from "../components/header/search/search";
import Promotions from '../Promotions/Promotion'

document.addEventListener('DOMContentLoaded',function () {
  let gumburger = $('.gamburger')[0];
  if (gumburger) {
    $('.gamburger').on('click', opentMobilePanel)
  }

  new Promotions;

  function opentMobilePanel(e) {
    let mm = e.target.closest('.utils').querySelector('.mobile-menu');
    mm.classList.toggle('show')
  }

  new Search();
  new cart()
});

