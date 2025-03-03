import SelectNew from "../../components/select/SelectNew";
import {$, post} from './../../common.js'
import './order.scss';

export default class Order {
   constructor() {
      this.$order = $('.order-edit').first();
      if (!this.$order) return;

      this.billId = $(this.$order).find('#order-id');
      this.$manager = $(`[select-new]`).first();

      new SelectNew(this.$manager);
      this.$order.addEventListener('customSelect.changed', this.changeUser.bind(this));
      this.$bill = $(`.bill`).first()

   }

   changeUser({detail}) {
      debugger;
      let data = this.dto(this, detail);

      let res = post('/adminsc/order/updateOrCreate', data)
   }

   dto(self, detail) {
      return {
         id: self.id,
         prev: detail?.prev,
         next: detail?.next
      }
   }

}