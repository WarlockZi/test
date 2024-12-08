import './users.scss'

import {$} from '../../common'
import SelectNew from "@src/components/select/SelectNew.js";

export default class User {
   constructor() {
      const item = $('[data-model="user"]')[0]
      if (!item) return false
      this.setSelects()
   }

   setSelects() {
      const selects = $('[select-new]:has(option)');
      [].forEach.call(selects, (select) => {
         new SelectNew(select)
      })
   }
   setRights()
   {
      let str = rights().replace(/,$/, "")
      let tab = $(`[data-field='rights']`)[0]
      tab.dataset.value = str
   }

   rights()
   {
      let right = $('.right:checked')
      let rights = '';
      [].map.call(right, (r) => {
         let str = r.previousElementSibling.innerText + ','
         rights += str
      }, rights)
      return rights
   }

   confirm()
   {
      const confirm = $('#conf option')
      for (let f of confirm) {
         if (f.selected) {
            return f.value
         }
      }
      return '0'

   }
}
// async handleClick({target}) {
//    if (!!target.closest('#save')) {
//
//       let wrapper = $('.user-item')[0]
//       let data = getModel(wrapper)
//
//       let res = await post('/adminsc/user/update', data)
//
//    } else if (target.classList.contains('right')) {
//       let rights = $('input.right:checked')
//       let str = '';
//       [].map.call(rights, function (right) {
//          let s = right.previousElementSibling.innerText
//          str += s + ','
//       })
//       let tab = target.closest('[data-tab]')
//       tab.dataset.value = str
//    }
// }













