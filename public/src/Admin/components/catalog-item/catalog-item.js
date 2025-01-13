import './catalog-item.scss';
import {$, debounce, post} from '../../../common.js';
import {ael} from "../../../constants.js";
import DTO from "../../../Admin/DTO.js";
import Checkbox from "../../../components/checkbox/checkbox.js";
import SelectNew from "../../../components/select/SelectNew.js";
import CustomDate from "../../../components/date/date.js";
import RelationDTO from "@src/Admin/RelationDTO.js";

export default class CatalogItem {
   constructor(catalogItem) {
      if (!catalogItem) return false

      this.model = catalogItem.dataset.model;
      this.id = +catalogItem.dataset.id;
      this.setCheckboxes()
      this.setSelects()
      this.setDates()

      catalogItem[ael]('click', this.handleClick.bind(this))
      catalogItem[ael]('keyup', debounce(this.handleKeyup.bind(this)))
      catalogItem[ael]('date.changed', this.handleDateChange.bind(this))
      catalogItem[ael]('customSelect.changed', this.handleSelectChange.bind(this))
      if (this.model) {
         catalogItem[ael]('checkbox.changed', this.handleChexboxChange.bind(this))
      }
   }

   setCheckboxes() {
      const checks = $('[my-checkbox]');
      [].forEach.call(checks, function (check) {
         new Checkbox(check)
      })
   }

   setDates() {
      const dates = $('[custom-date]');
      [].forEach.call(dates, function (date) {
         new CustomDate(date)
      })
   }

   setSelects() {
      const selects = $('[select-new]:has(option)');
      [].forEach.call(selects, function (select) {
         if (!select.parentNode.hasAttribute('hidden'))
            new SelectNew(select)
      })
   }

   handleChexboxChange({target}) {
      if (target.closest('[custom-table]')) return
      this.update(target)
   }

   async handleSelectChange({target}) {
      if (target.closest('[custom-table]')) return
      this.update(target)
   }

   async handleDateChange({target}) {
      this.update(target)
   }

   async handleKeyup({target}) {
      if (target.closest('.custom-table')) return false
      if (!target.hasAttribute('contenteditable') ||
         !target.dataset.field) return false
      let dto = {}
      if (target.dataset.relation) {
         dto = new RelationDTO(target)
      } else {
         dto = new DTO(this.id, target)
      }
      const res = await post(`/adminsc/${this.model}/updateOrCreate`, dto)
      if (res) {
         target.dispatchEvent(new CustomEvent('catalogItem.changed',
            {bubbles: true, detail: {res}})
         )
      }
   }

   async handleClick({target}) {
      if ((target.classList.contains('tab'))) {
         this.handleTabClick(target)
      }
   }

   handleTabClick(target) {
      $(`[data-tab].show`).first().classList.toggle('show');
      $(`[data-tab='${target.dataset.tabId}']`).first().classList.toggle('show');
      $(`.tab.active`).first().classList.toggle('active');
      target.classList.toggle('active')
   }

   async update(target) {
      if (target.closest('[custom-table]')) return
      const dto = new DTO(this.id, target)
      const res = await post(`/adminsc/${this.model}/updateorcreate`, dto)
   }
}