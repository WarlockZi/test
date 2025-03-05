import './promotion.scss'
import {$, post} from '../common'
import SelectNew from "../components/select/SelectNew";

export default class Promotion {
   constructor() {
      this.$promotion = $('.promotion-edit').first();
      if (!this.$promotion) return;
      this.updateUrl = '/adminsc/promotion/updateOrCreate'
      this.id = $(this.$promotion).find(`[data-field='id']`).innerText;
      this.$count = $(`[data-field='count']`).first();

      this.$unit = $('[select-new].unit').first();
      new SelectNew(this.$unit);
      $(`[data-field="unit"]`).first().addEventListener('customSelect.changed', this.unitChanged.bind(this));

      this.$newPrice = $(`[data-field="new_price"]`).first();

      this.$activeTill = $(`[data-field='active-till']`).first();
      this.$activeTill.addEventListener('change', this.activetillChanged.bind(this));
   }

   unitChanged(customEvent) {
      let data = this.dto(this);
      data.unit_id = customEvent.detail.next.value;
      let res = post(this.updateUrl, data);

   }

   async activetillChanged({target}) {
      let data = this.dto(this);
      data.active_till = target.value;
      let res = await post(this.updateUrl, data);
      if (res) {
      }
   }

   dto(self) {
      return {
         id: this.id,
      }
   }


}