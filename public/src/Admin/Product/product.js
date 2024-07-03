import './product.scss'
import './units'
import './Values'
import {$, objAndFiles2FormData, post} from '../../common'
import {d, qs, qa, ael} from '../../constants'
// import shippableTable from "../../share/shippable/shippableUnitsTable";


import {Fields} from "./Fields";

import Values from "./Values";

import Dnd from "../../components/dnd/dnd";

export default async function product() {
  const product = document[qs](`.item-wrap[data-model='product']`)
  if (!product) return false;

  new Values(product);

  new Fields(product);
  const dragNdrop = document[qs]('[dnd]')
  if (dragNdrop){
    const {default:Dnd} =  await import("../../components/dnd/dnd")
    new Dnd(dragNdrop,addMainImage)
  }
  setCardPanel()

  // new Dnd(), addMainImage);
}

async function setCardPanel(){
  const cardPanel = document[qs](`.cardPanel`)
  if (cardPanel){
    const {default:cardPanel} = import("./../../share/card_panel/card_panel")
    new cardPanel()
  }
}
async function addMainImage(files, target) {

  const obj = {productId: target.closest('.item-wrap').dataset.id,};
  // debugger
  let data = objAndFiles2FormData(obj, files[0]);

  let res = await post('/adminsc/product/saveMainImage', data);
  let src = res?.arr[0];
  if (src) {
    let mainImage = target.closest('.dnd-container').querySelector('img');
    mainImage.removeAttribute("src");
    mainImage.setAttribute("src", src)
  }
}


