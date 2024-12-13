import './ProductFilter.css'
import {ael, qa} from "@src/constants.js";
import {$, post} from "@src/common.js";
import SelectNew from "@src/components/select/SelectNew.js";

export default class ProductFilter {
   constructor() {
      const el = $('.filter-wrap').first()
      if (!el) return
      this.wrap = el
      this.url = '/adminsc/report/filter'
      this.submitBttn = $(this.wrap).find('.filter-button')
      this.submitBttn[ael]('click', this.submit.bind(this))
      this.setSelects()
   }
   setSelects(){
      const selects = this.wrap[qa](`[select-new]`);
      [].map.call(selects, select => {
         new SelectNew(select)
      });
   }

   async submit(e) {
      e.preventDefault();
      const req = {};

      const selected = this.wrap[qa](`[select-new]:not([data-value="0"])`);
      [].map.call(selected, select => {
         req[select.getAttribute('name')] = select.dataset.value;
         return null;
      });

      const checked = this.wrap[qa](`[type='checkbox']:checked`);
      [].forEach.call(checked, check => {
         req[check.name]='on'
      })

      const headers = {
         "Content-Type": "application/x-www-form-urlencoded",
         "Accept": "application/json",
      }
      const res = await post(this.url, req);

      $('.used-filters').first().innerHTML = res?.arr?.filterString
      $('.list-filter').first().innerHTML = res?.arr?.filterPanel
      const table = $('[custom-table]').first()
      table.innerHTML = res?.arr?.products
      this.setSelects()
   }
}