import {$, post} from '../../common'

let item = $('.item-wrap').first();
item.addEventListener('customSelect.changed', selectChanged);

async function selectChanged(obj) {
  let action = obj.target;

  let data = valDto();
  data.morphed.old_id = obj.detail.prev.value;
  data.morphed.new_id = obj.detail.next.value;

  let url = '/adminsc/product/changeVal';

  let res = await post(url, data)
}

function valDto() {
  return {
    morph: {
      model: 'product',
      id: item.dataset.id,
    },
    morphed: {
      model: 'val',
      old_id: 0,
      new_id: 0
    }
  }
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
