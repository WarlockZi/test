import './card.scss'
import {zoom} from './zoom'
import {quill} from './quill'
import {shortLink} from './shortLink'
import {$} from "../common";
import shippableTable from "../share/shippable/shippableUnitsTable";
import {d, qs} from "../constants";

window.onload = function () {

  // new toCart();
  const product = $('.product-card').first();
  if (!product) return false
  const table = $('.shippable-table').first()
  new shippableTable(table)

  // product.addEventListener('click', handleShippableUnitsTableClick.bind(product))
  // handleShippableUnitsTableClick()
  zoom()
  shortLink()

  quill()
};
