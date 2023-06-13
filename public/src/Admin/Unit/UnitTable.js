import {$, createElement, post} from '../../common'
import WDSSelect from "../../components/select/WDSSelect";
import SelectNew from "../../components/select/SelectNew";


export default class UnitTable {
  constructor(tableClass) {
    this.$table = $(tableClass).first();
    if (!this.$table) return;

    this.productId = +$('.item-wrap').first().dataset.id;
    this.product1sId = $(`[data-field='1s_id']`).first().innerText;
    this.$baseUnit = $(`[data-field='base_unit'] [data-field='base_unit']`).first();
    this.baseUnitId = this.$baseUnit.options[this.$baseUnit.selectedIndex].value;

    this.$addUnit = $('.add-unit').first();
    this.$rows = $('.rows').first();
    this.$selector = $(this.$rows).find('[select-new]');

    this.$addUnit.onclick = this.createRow.bind(this);
    this.$rows.onchange = this.update.bind(this);
    this.$rows.onclick = this.clickRow.bind(this);
    this.$rows.addEventListener('customSelect.changed', this.unitChanged.bind(this));

    this.initSelects();
    setTimeout(this.deleteSelected.bind(this), 800)
  }

  initSelects(){
    debugger;
    this.$rows.querySelectorAll('[select-new]').forEach((s)=>{
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

  createRow() {
    let baseUnitText = this.$baseUnit.selectedOptions[0].innerText;

    let row = (new createElement()).tag('div').attr('class', 'row').get();
    let $selector = this.$selector.cloneNode(true);

    let multiplier = (new createElement()).attr('type', 'number').tag('input').attr('value', 10).get();
    let baseUnit = (new createElement()).tag('div').attr('class', 'base-unit').text(baseUnitText).get();
    let del = (new createElement()).tag('div').attr('class', 'del').text('X').get();

    row.append($selector);
    row.append(multiplier);
    row.append(baseUnit);
    row.append(del);

    new WDSSelect($selector);

    this.$rows.append(row);
    this.deleteSelected()
  }

  async unitChanged(obj) {
    debugger;
    let data = this.dto(obj.target.closest('.row'));
    data.next = obj.detail.next.value;
    data.prev = obj.detail.prev.value;
    if (obj.detail.next.value)
      this.deleteSelectedUnitFromSelects(obj.detail.next.value);

    if (obj.detail.prev.value)
      this.addDeletedUnitToSelects(obj.detail.prev);

    let res = await post('/adminsc/unit/changeUnit', data)
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
      let res = await post('/adminsc/unit/detachunit', data);
      debugger;
      if (res?.arr?.ok) {
        row.remove()
      } else if (target.tagName === 'INPUT') {
        this.update()
      }
    }
  }

  async update(e) {
    let target = e.target;
    let row = target.closest('.row');
    let data = this.dto(row);

    let res = await post('/adminsc/unit/updatePivot', data);
    this.createRow(res)
  }

  dto(row) {
    let unitId = +this.getUnitId(row);
    let pivot = {
      'product_id': this.product1sId,
      'multiplier': +$(row).find('input').value ?? 0,
    };
    return {
      baseUnit: this.getBaseUnitId(),
      unitId: unitId,
      pivot: pivot ?? null
    }
  }

  getBaseUnitId() {
    return +this.$baseUnit.options[this.$baseUnit.selectedIndex].value
  }

  getUnitId(row) {
    let classSelected = row.querySelector('[select-new] .selected');

      return classSelected.dataset.value ?? 0

  }

}