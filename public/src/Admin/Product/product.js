import './product.scss'
import './units'
import './Values'
import {$, popup, post} from '../../common'
import Morph from "../../components/morph/morph";
import SelectNew from "../../components/select/SelectNew";

export default function product() {
  let product = $(`.item-wrap[data-model='product']`).first();
  if (!product) return false;

  new Values(product);

  let dnds = $('[data-dnd-path]');
  dnds.forEach((dnd) => {
    if (dnd.parentNode.dataset.morphFunction) {
      let m = new Morph(dnd.parentNode, product)
    }
  });

}


