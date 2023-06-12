import './product.scss'
import './units'
import './properties'
import {$, popup, post} from '../../common'
import Morph from "../../components/morph/morph";

export default function product() {


  let product = $(`.item-wrap[data-model='product']`)[0];
  if (!product) return false;

  let dnds = $('[data-dnd-path]');
  dnds.forEach((dnd) => {
    if (dnd.parentNode.dataset.morphFunction) {
      let m = new Morph(dnd.parentNode, product)
    }
  });

  // let selects = [...$('[custom-select]',...$('[select-new]'))]


  // selects.forEach((s)=>{
  //   let field
  // })



}