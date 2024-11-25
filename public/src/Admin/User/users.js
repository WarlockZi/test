import './users.scss'
import {$, post} from "@src/common.js";
import Select from "@src/components/select/SelectNew.js";
import {ael} from "@src/constants.js";
import DTO from "@src/Admin/DTO.js";

export default class Users {
   constructor() {
      const table = $(`[data-model='user']`)[0]
      table[ael]('customSelect.changed',this.selectChange.bind(this))
      this.setSelects()
   }

   setSelects() {
   const selects = $('[custom-select]');
      [].forEach.call(selects,select=>{
         new Select(select)
      })
   }
   selectChange(e){
      const role_id =  e.detail.next.value
      const user_id =  e.detail.target.parentNode.dataset.id
      const dto = new DTO()
      dto.id = user_id
      dto.relation.name = e.detail.target?.dataset?.relation
      dto.relation.fields = {
         // user_id,
         role_id,
      }
      const res = post('/adminsc/user/changeRole',dto)


   }
}


