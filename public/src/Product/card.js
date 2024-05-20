import './card.scss'
import toCart from './toCart'
import {zoom} from './zoom'
import {quill} from './quill'
import {shortLink} from './shortLink'
import handleShippableUnitsTableClick from "../share/shippableUnitsTable";
import {$} from "../common";

window.onload = function () {

  // new toCart();
  const product = $('.product-card').first();
  if (!product) return false

  product.addEventListener('click', handleShippableUnitsTableClick.bind(product))
  handleShippableUnitsTableClick()
  zoom()
  shortLink()
  quill()
};
