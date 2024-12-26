import './ProductFilter.css'
import {ael, qa, qs} from "@src/constants.js";
import {$, post} from "@src/common.js";
import SelectNew from "@src/components/select/SelectNew.js";

export default class ProductFilter {
   constructor(productsFilter) {
      if (!productsFilter) return
      this.wrap = productsFilter
      this.panel = productsFilter[qs]('.list-filter')
      this.url = '/adminsc/report/filter'
      this.wrap[ael]('click', this.handleClick.bind(this))
      this.setSelects()
   }

   setSelects() {
      const selects = this.wrap[qa](`[select-new]`);
      [].map.call(selects, select => {
         new SelectNew(select)
      });
   }

   async handleClick(e) {
      const target = e.target;
      if (target.classList.contains('filter-button')) {
         e.preventDefault();
         const req = this.getClickedFilters();
         const res = await post(this.url, req);
         this.renderDataFromResponce(res)
      }
   }
   getClickedFilters() {
      const req = {};

      const selected = this.wrap[qa](`[select-new]`);
      [].map.call(selected, select => {
         req[select.getAttribute('name')] = select.dataset.value;
         return null;
      });

      const checked = this.panel[qa](`[type='checkbox']:checked`);
      [].forEach.call(checked, check => {
         req[check.name] = 'on'
      })
      return req;
   }
   renderDataFromResponce(res) {
      $('.used-filters').first().innerHTML = res?.arr?.filterString
      $('.list-filter').first().innerHTML = res?.arr?.filterPanel
      const table = $('[custom-table]').first()
      table.innerHTML = res?.arr?.productsTable
      this.setSelects()
   }
}