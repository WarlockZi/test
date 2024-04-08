import {$, createElement, post} from '../../common'
import WDSSelect from "../../components/select/WDSSelect";
import cartLogin from "../../components/Modal/modals/CartLogin";

export default class Property {
  constructor(selectSelector) {
    if (!selectSelector) return;
    this.selectSelector = selectSelector;

    this.productId = +$('.item-wrap').first().dataset.id;
    this.product1sId = $(`[data-field='1s_id']`).first().innerText;
    this.$baseUnit = $(`[data-field='base_unit'] [data-field='base_unit']`).first();
    this.baseUnitId = this.$baseUnit.options[this.$baseUnit.selectedIndex].value;

    this.$addUnit = $('.add-unit').first();
    this.$rows = $('.rows').first();
    this.$selector = $(this.$rows).find('[custom-select]');

    this.$rows.onchange = this.update.bind(this);
    this.$addUnit.onclick = this.createRow.bind(this);
    this.$rows.onclick = this.clickRow.bind(this);
    this.$rows.addEventListener('customSelect.changed', this.unitChanged.bind(this))
  }

  async unitChanged(obj) {

    let dto = this.dto(obj.target.closest('.row'));
    dto.next = obj.detail.next.value;
    dto.prev = obj.detail.prev.value;

    let res = await post('/adminsc/unit/changeUnit', dto)
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
    let pivot;
    let unitId = +this.getUnitId(row);
    if (row) {
      pivot = {
        'product_id': this.product1sId,
        'multiplier': +$(row).find('input').value ?? 0,
      }
    }
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
    let classSelected = row.querySelector('[custom-select] .selected');
    if (classSelected) {
      return classSelected.dataset.value ?? 0
    } else {
      let select = row.querySelector('select');
      return select.options[select.options.selectedIndex].value ?? 0
    }
  }

  createRow(res) {
    res = {
      multiplier: 10,
      baseUnit: this.$baseUnit.selectedOptions[0].innerText
    };
    let row = (new createElement()).tag('div').attr('class', 'row').get();
    let selector = this.$selector.cloneNode(true);

    let multiplier = (new createElement()).attr('type', 'number').tag('input').attr('value', res.multiplier).get();
    let baseUnit = (new createElement()).tag('div').attr('class', 'base-unit').text(res.baseUnit).get();
    let del = (new createElement()).tag('div').attr('class', 'del').text('X').get();

    row.append(selector);
    row.append(multiplier);
    row.append(baseUnit);
    row.append(del);
    new WDSSelect(selector);

    this.$rows.append(row)
  }
}