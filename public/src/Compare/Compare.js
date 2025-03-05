import './compare.scss'

import {$, post} from "@src/common.js";
import {ael} from "@src/constants.js";
import DTO from "@src/Admin/DTO.js";

export default class Compare{
   constructor(){
      const compare = $('[data-compare]').first()
      if (!compare) return false

      compare[ael]('click', this.handleClick.bind(this));
   }

   handleClick({target}) {
      if (target.classList.contains('compare')) {
         this.remove(target)
      }
   }

   async remove(target) {
      const productCard = target.closest('.column')
      const res = await post('/compare/del', this.productDTO(target))
      if (res?.arr?.discompared) productCard.remove();

   }
   productDTO(target) {
      const dto = new DTO(target);
      dto.fields = {
         product_id: target.closest(`[data-1sid]`).dataset['1sid'],
      }
      return dto
   }
}