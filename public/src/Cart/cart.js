import './counter1'
import {$, cookieRemove, formatter, getPhpSession, post, sanitizeInput,} from '../common'
// import Counter1 from "./counter1";
import Cookie from "../components/cookie/new/cookie";
import Modal from "../components/Modal/modal";
import CartSuccess from "../components/Modal/modals/CartSuccess";
import CartLogin from "../components/Modal/modals/CartLogin";
import CartLead from "../components/Modal/modals/CartLead";
import {ael, it, qa, qs} from '../constants';
import shippableTable from "../share/shippable/shippableUnitsTable";

export default class Cart {
   constructor() {
      this.container = $('.user-content .cart .content').first();
      if (!this.container) return;

      this.container[ael]('click', this.handleClick.bind(this));
      this.container[ael]('keyup', this.handleKeyUp.bind(this));
      // container[ael]('click', handleShippableUnitsTableClick.bind(this))

      // this.cartDeadline = this.cartLifeMs + Date.now()
      this.total = this.container[qs]('.total span');
      this.$cartEmptyText = this.container[qs]('.empty-cart');
      this.$cartCount = this.container[qs]('.cart .count');
      this.rows = this.container[qa]('.row');
      this.url = '/cart'

      this.mapTables()
      this.renderSums()
      this.cookie = new Cookie();
      // this.setCounter()
      this.setModals()
   }

   renderSums() {
      const total = [...this.container[qa]('[shippable-table]')]
         .reduce((acc, table) => {
            const price = +table.dataset.price;
            const sum = [...table[qa]('[unit-row]')].reduce(
               function (acc, unitRow) {
                  const multi = +unitRow.dataset.multiplier
                  const count = +unitRow[qs]('input').value
                  const sum = multi * price * count
                  const sub_sum = unitRow[qs]('.subSum')
                  if (sub_sum) sub_sum[it] = formatter.format(sum)
                  return acc + sum
               }.bind(price), 0)
            const tableSum = table.closest('.row')[qs]('.sub-sum')
            tableSum[it] = formatter.format(sum)
            return acc + sum
         }, 0)
      this.total[it] = formatter.format(total)
   }

   mapTables() {
      [...this.container[qa]('.shippable-table')]
         .forEach((table) => {
            new shippableTable(table)
         })
   }


   async dropCart() {
      const cartToken = getPhpSession();
      const res = await post('/cart/drop', {cartToken});
      if (res?.arr?.ok) {
         this.showEmptyCart()
      }
   }

   rowUnitIds(row) {
      return [...row[qa]('[unit-row]')].map((unitRow) => {
         return unitRow.dataset.unitid
      })
   }

   cartRowDTO(target) {
      const row = target.closest('.row');
      return {
         sess: getPhpSession(),
         product_id: row.dataset.productId,
         unit_ids: this.rowUnitIds(row),
      }
   }

   async handleClick({target}) {
      if (target.classList.contains('del')) {
         await this.deleteCartRow(target)
         this.renderSums()
      } else if (target.classList.contains('plus') || target.classList.contains('minus')) {
         if (this.rowTotalCount(target.closest('.row'))) {
            this.renderSums()
            this.changeCount(target)
         } else {
            this.renderSums()
         }
      }
   }

   changeCount(target) {
   }

   async handleKeyUp({target}) {
      if (target.classList.contains('input') && target.tagName === 'INPUT') {
         this.renderSums()
         const count = +target.value
         this.updateOrCreate(target, count)
      }
   }

   rowTotalCount(table) {
      return [...table[qa]('input')].reduce((acc, el) => {
         return acc + (+el.value)
      }, 0)
   }

   updateOrCreate(target, count) {
      const product_id = target.closest('[shippable-table]').dataset['1sid'];
      const unit_id = target.closest('[unit-row]').dataset['unitid'];
      post(`${this.url}/updateOrCreate`, {product_id, unit_id, count})
   }

   async deleteCartRow(target) {
      const res = await post(`${this.url}/deleteRow`, this.cartRowDTO(target));
      if (res?.arr?.ok) {
         target.closest('.row').remove();
         if (this.rows.length < 1) this.showEmptyCart()
         this.renderSums()
      }
   }

   showEmptyCart() {
      this.container.innerHTML = '';
      this.$cartEmptyText.classList.remove('none')
      this.$cartCount.classList.add('none')
   }

   setModals() {
      const lead = document[qs]('#cartLead')
      const login = document[qs]('#cartLogin')
      const success = document[qs]('#cartSuccess')
      if (lead) {
         new Modal({
            button: lead,
            data: new CartLead(),
            callback: this.modalLeadCallback.bind(this)
         });
      }
      if (login) {
         new Modal({
            button: login,
            data: new CartLogin(),
            callback: this.modalLoginCallback.bind(this)
         });
      }

      if (success) {
         new Modal({
            button: success,
            data: new CartSuccess(),
            callback: this.modalcartSuccessCallback.bind(this)
         });
      }
   }

   async modalLeadCallback(fields, modal) {
      const name = sanitizeInput(fields.name.value);
      const phone = sanitizeInput(fields.phone.value);
      const company = sanitizeInput(fields.company.value);
      const sess = getPhpSession();
      const res = await post('/cart/lead', {name, phone, company, sess});
      modal.close();
      if (res) {
         location.reload()
      }
   }

// <script>alert('dd');</sctipt>

   async modalcartSuccessCallback(inputs, modal) {
      modal.close()
   }

   async modalLoginCallback(fields, modal) {
      const email = sanitizeInput(fields.email.value);
      const password = sanitizeInput(fields.password.value);
      const sess = getPhpSession();
      const res = await post('/cart/login', {email, password, sess});
      modal.close();
      if (res) {
         location.reload()
      }
   }

   counterCallback() {
      cookieRemove('cartDeadline')
      this.dropCart().then()
   }

}