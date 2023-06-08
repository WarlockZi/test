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

//// Property set
  let property = $(`[data-model='product'] [custom-select][data-model="property"]`);
  if (property) {
    [].map.call(property, function (prop) {

      let observer = new MutationObserver(function (mutations) {
        mutations.forEach(function (mutation) {
          let propertable_id = $('.item-wrap')[0].dataset.id;
          let property_id = mutation.target.dataset.modelId;
          let val_id = mutation.target.dataset.value;
          post('/adminsc/product/setProperty',
            {propertable_id, property_id, val_id})

        });
      });

      observer.observe(
        prop, {attributes: true,}
      );
    })
  }

}