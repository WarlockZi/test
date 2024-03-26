import './card.scss'
import toCart from './toCart'
import {zoom} from './zoom'
import {quill} from './quill'
import {shortLink} from './shortLink'

window.onload = function () {
  new toCart();
  zoom()
  shortLink()
  quill()
};
