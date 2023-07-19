import './product.scss'
import './units'
import './Values'
import {$, objAndFiles2FormData, post} from '../../common'
// import Morph from "../../components/morph/morph";
import {Fields} from "./Fields";

import Values from "./Values";

import Dnd from "../../components/dnd/dnd";

export default function product() {
  let product = $(`.item-wrap[data-model='product']`).first();
  if (!product) return false;

  new Values(product);

  new Fields(product);

  new Dnd($('.add-file')[0], addMainImage)
}

async function addMainImage(files, target) {
  let data = objAndFiles2FormData({}, files[0]);
  let res = await post('/adminsc/product/attachMainImage', data);
  let src = res?.arr[0];
  if (src) {
    let mainImage = target.closest('.dnd-container').querySelector('img');
    mainImage.removeAttribute("src");
    mainImage.setAttribute("src", src)
  }
}


