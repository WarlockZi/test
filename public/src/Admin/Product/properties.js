import {$} from '../../common'
import Property from '../Property/Property'

debugger;

let item = $('.item-wrap').first();
item.addEventListener('customSelect.changed', selectChanged);

async function selectChanged(obj) {
  let res = await post('/adminsc/product/changeval',obj)
}