import {$, post} from '../../common'
import Property from '../Property/Property'

let item = $('.item-wrap').first();
item.addEventListener('customSelect.changed', selectChanged);

async function selectChanged(obj) {
  debugger;
  let propertable_id = $('.item-wrap')[0].dataset.id;
  let property_id = mutation.target.dataset.modelId;
  let val_id = mutation.target.dataset.value;
  post('/adminsc/product/setProperty',
    {propertable_id, property_id, val_id});

  let res = await post('/adminsc/product/changeval', obj)

}
// [].map.call(property, function (prop) {
//   let observer = new MutationObserver(function (mutations) {
//     mutations.forEach(function (mutation) {
//     });
//   });
//   observer.observe(
//     prop, {attributes: true,}
//   );
// })
