import {$, post} from '../../common'
import Property from '../Property/Property'

let item = $('.item-wrap').first();
item.addEventListener('customSelect.changed', selectChanged);

async function selectChanged(obj) {
  debugger;
  let res = await post('/adminsc/product/changeval',obj)
}