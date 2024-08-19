import {$, createElement, post} from '../../common'
import SelectNew from "../../components/select/SelectNew";
import {it, qa} from '../../constants'


export default class UnitTable {
   constructor(tableClass) {
      this.$table = $(tableClass).first();
      if (!this.$table) return;

      this.product1sId = $(`[data-field='1s_id']`).first().innerText;

      this.$baseUnit = $(`select`).first();
      // this.baseUnitId = this.$baseUnit.options[this.$baseUnit.selectedIndex].value;

      this.$addUnit = $('.add-unit').first();
      this.$rows = $('.rows').first();
      // this.$selector = $(this.$rows).find('[select-new]');
      this.$emtyRow = $(this.$rows).find('.none');

      this.$addUnit.onclick = this.createRow.bind(this);
      this.$rows.onchange = this.handleChange.bind(this);
      this.$rows.onkeyup = this.handleKeyUp.bind(this);
      this.$rows.onclick = this.clickRow.bind(this);
      this.$rows.addEventListener('customSelect.changed', this.unitChanged.bind(this));

      this.initSelects();
      setTimeout(this.deleteSelected.bind(this), 800)
   }

   initSelects() {
      this.$rows.querySelectorAll('[custom-select]').forEach((s) => {
         new SelectNew(s)
      })
   }

   deleteSelected() {
      let selected = this.$rows.querySelectorAll('.selected');
      selected = Array.from(selected).map((s) => {
         if (+s.dataset.value) return s.dataset.value;
      });
      this.$table.querySelectorAll('[custom-select]').forEach(
         function (select) {
            select.querySelectorAll('li').forEach(function (o) {
               if (selected.includes(o.dataset.value)) {
                  o.remove()
               }
            })
         }
      )
   }

   createSelect(el) {
      const select = (new createElement()).tag('select').attr('new-select').className('name').get()

      const lis = [...el[qa]('li')].map((li) => {
         const op = (new createElement()).tag('option').attr('value', li.dataset.value).text(li[it]).get()
         select.append(op)
      })
      return select
   }

   createRow() {
      let baseUnitText = this.$baseUnit.selectedOptions[0].innerText;

      let row = (new createElement()).tag('div').attr('class', 'row').get();
      const select = this.createSelect(this.$emtyRow)

      let multiplier = (new createElement()).attr('type', 'number').tag('input').attr('value', 10).className('multiplier').get();
      let baseUnit = (new createElement()).tag('div').attr('class', 'base-unit').text(baseUnitText).get();
      let minUnit = (new createElement()).tag('div').className('shippable').get();
      let minUnitInput = (new createElement()).tag('input').attr('type', 'checkbox').get();
      let del = (new createElement()).tag('div').attr('class', 'del').text('X').get();

      row.append(select);
      row.append(multiplier);
      row.append(baseUnit);
      minUnit.append(minUnitInput);
      row.append(minUnit);
      row.append(del);

      new SelectNew(select);

      this.$rows.append(row);
      // this.deleteSelected()
   }

   async unitChanged(obj) {
      let data = this.dto(obj.target.closest('.row'));
      data.morphed.new_id = obj.detail.next.value;
      data.morphed.old_id = obj.detail.prev.value;
      if (obj.detail.next.value)
         this.deleteSelectedUnitFromSelects(obj.detail.next.value);

      if (obj.detail.prev.value)
         this.addDeletedUnitToSelects(obj.detail.prev);

      let res = await post('/adminsc/product/changeUnit', data)
   }

   deleteSelectedUnitFromSelects(value) {
      this.$table.querySelectorAll('[custom-select]').forEach(
         function (select) {
            let options = select.querySelectorAll('li');
            options.forEach(function (o) {
               if (o.dataset.value === value) {
                  o.remove()
               }
            })
         }
      )
   }

   addDeletedUnitToSelects() {
      this.$table.querySelectorAll('[custom-select]').forEach(
         function (select) {
            let options = select.querySelectorAll('li');
            options.forEach(function (o) {
               if (o.dataset.value === value) {
                  o.remove()
               }
            })
         }
      )
   }

   async clickRow({target}) {
      if (target.classList.contains('del')) {
         let row = target.closest('.row');
         let data = this.dto(row);
         let res = await post('/adminsc/product/deleteUnit', data);
         if (res?.arr?.ok) {
            row.remove()
         }
      }
   }

   handleKeyUp(e) {
      let multiplier = +e.target.value;
      if (!/\d+/.test(multiplier)) {
         return
      }
      this.update(e, this)
   }

   async handleChange({target}) {
      if (target.type === 'checkbox' && target.hasAttribute('data-isbase')) {
         const base_is_shippable = +target.checked
         const product_1s_id = this.product1sId
         const data = {product_1s_id,base_is_shippable}
         const res = await post('/adminsc/product/changeBaseIsShippable', data);
      } else {
         this.update(target, this)
      }
   }

   async update(target, self) {
      let row = target.closest('.row');
      let chosenUnit = +$(row).find('[select-new]').dataset.value;
      if (!chosenUnit) return false;
      let data = self.dto(row);
      data.morphed.new_id = data.morphed.old_id;

      const res = await post('/adminsc/product/changeUnit', data);

   }

   dto(row) {
      let pivot = {
         'product_id': this.product1sId,
         'multiplier': +$(row).find(`.multiplier`).value ?? 0,
         'is_shippable': $(row).find(`.shippable input`).checked ? 1 : null,
      };
      let morphed = {
         new_id: 0,
         old_id: +this.getUnitId(row),
         detach: 0
      };
      return {
         baseUnitId: this.getBaseUnitId(),
         pivot, morphed
      }
   }

   getBaseUnitId() {
      return +this.$baseUnit.options[this.$baseUnit.selectedIndex].value
   }

   getUnitId(row) {
      let classSelected = row.querySelector('[select-new]');
      return classSelected.dataset.value ?? 0
   }

}