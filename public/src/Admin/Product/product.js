import './product.scss'
import './units'
import {$, popup, post} from '../../common'
import Morph from "../../components/morph/morph";

export default function product() {

  let product = $(`.item_wrap[data-model='product']`)[0];
  if (!product) return false;

  // let morphs = $('[data-morph-model]')
  let dnds = $('[data-dnd-path]');

  // debugger
  dnds.forEach((dnd) => {
    if (dnd.parentNode.dataset.morphFunction) {
      let m = new Morph(dnd.parentNode, product)
    } else if (dnd.parentNode.dataset.belongsTo) {
    }
  });

  // let morphs =

  let customSelects = $('[custom-select]');

  customSelects.forEach((sel)=>{
    if (sel.dataset.morphModel){
      let m = 1
    } else{
      let m = 1
    }
  });

//// Property set
  let property = $(`[data-model='product'] [custom-select][data-model="property"]`);
  if (property) {
    [].map.call(property, function (prop) {

      let observer = new MutationObserver(function (mutations) {
        mutations.forEach(function (mutation) {
          let propertable_id = $('.item_wrap')[0].dataset.id;
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

  function validateType(file) {
    if ([
      'image/png',
      'image/jpeg',
      'image/jpg',
      'image/webp',
      'image/gif'
    ].includes(file.type)) return true;
    popup.show(`Тип файлa ${file['name']} должен быть jpg, jpeg, png, webp, gif`);
    return false
  }


}