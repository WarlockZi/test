import './product.scss'
import './units'
import './Values'
import {$, objAndFiles2FormData, post} from '../../common'
// import Morph from "../../components/morph/morph";
import {Fields} from "./Fields";

import Values from "./Values";
import DndFile from "../../components/dnd/DndFile";
import Dnd from "../../components/dnd/dnd";

export default function product() {
  let product = $(`.item-wrap[data-model='product']`).first();
  if (!product) return false;

  new Values(product);

  new Fields(product);

  new Dnd($('.add-file')[0], addMainImage)
  // new Relations(product);
  //   debugger
  // let dnds = $('[data-dnd-path]');
  // dnds.forEach((dnd) => {
  //   if (dnd.parentNode.dataset.morphFunction) {
  //     let m = new Morph(dnd.parentNode, product)
  //   }
  // });
}

async function addMainImage(files, target) {
  let datas = {

  };

  let data = objAndFiles2FormData(datas, files[0]);

  let res = await post('/adminsc/product/attachMainImage', data);
  if (res) {
    rerenderMainImage(res, target)
  }
}

function rerenderMainImage(res, target) {

}
