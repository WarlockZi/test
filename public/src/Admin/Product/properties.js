import {$, post} from '../../common'

let item = $('.item-wrap').first();
let obj = {
  model: item.dataset.model,
  id: item.dataset.id
};
let properies = $('.item-wrap .properties').first();
if (properies) {
  properies.addEventListener('customSelect.changed', selectChanged.bind(obj));
}

async function selectChanged(obj) {
  let action = obj.target;

  let data = (this.model === 'product') ? valDto() :
    (this.model === 'category') ? propertyDto(obj) : null;

  data.morphed.old_id = obj.detail.prev.value;
  data.morphed.new_id = obj.detail.next.value;

  let res = await post(`/adminsc/${this.model}/changeVal`, data)
}

function valDto() {
  return {
    product_id: item.dataset.id,
    morphed: {
      old_id: 0,
      new_id: 0
    }
  }
}

function propertyDto(obj) {
  return {
    category_id: item.dataset.id,
    morphed: {
      old_id: +obj.detail.prev.value,
      new_id: +obj.detail.next.value
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
