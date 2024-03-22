import './product.scss'
import './units'
import './Values'
import {$, objAndFiles2FormData, post} from '../../common'
// import Morph from "../../components/morph/morph";
import {Fields} from "./Fields";

import Values from "./Values";

import Dnd from "../../components/dnd/dnd";

export default function product() {
  const product = $(`.item-wrap[data-model='product']`).first();
  if (!product) return false;

  new Values(product);

  new Fields(product);

  new Dnd($('.add-file')[0], addMainImage);

  let baseEqMainUnit = product.querySelector(`[data-action='equal']`);
  baseEqMainUnit.onchange = setEqual
}

async function setEqual({target}) {
  let data = {
    ['1s_id']: target.closest('.item_content').querySelector(`[data-field="1s_id"]`).innerText,
    'equal': +target.checked
  };
  let res = await post('/adminsc/product/Setbaseequalmainunit', data)
}

async function addMainImage(files, target) {

  const obj = {productId: target.closest('.item-wrap').dataset.id,};
  // debugger
  let data = objAndFiles2FormData(obj, files[0]);

  let res = await post('/adminsc/product/attachMainImage', data);
  let src = res?.arr[0];
  if (src) {
    let mainImage = target.closest('.dnd-container').querySelector('img');
    mainImage.removeAttribute("src");
    mainImage.setAttribute("src", src)
  }
}


