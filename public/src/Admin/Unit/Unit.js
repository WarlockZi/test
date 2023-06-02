import {$, createElement, post} from '../../common'

export default class Unit {
  constructor(tableClass) {
    this.$table = $(tableClass).first();
    if (!this.$table) return;

    this.productId = $('.item_wrap').first().dataset.id;

    this.$addUnit = $('.add-unit').first();
    this.$baseUnit = $(`[data-field='base_unit'] [data-field='base_unit']`).first();
    this.$rows = $('.rows').first();
    this.$selector = $(this.$rows).find('[custom-select]');

    this.$rows.onchange = this.update.bind(this);
    this.$addUnit.onclick = this.createRow.bind(this)
  }


  async update({target}) {
    let row = target.closest('.row');
    let data = this.dto(row);
    if (!data.pivot.unitId || !data.pivot.multiplier) return false;
    let res = await post('/adminsc/unit/attachUnit', data);
    this.createRow(res)
  }

  dto(row) {
    let pivot;
    let unitId = this.getUnitId(row);
    if (row) {
      pivot = {
        'unitId': unitId,
        'multiplier': $(row).find('input').value ?? 0,
      }
    }
    return {
      productId: this.productId,
      pivot: pivot ?? null
    }
  }

  getUnitId(row) {
    let classSelected = row.querySelector('[custom-select] .selected');
    if (classSelected) {
      return classSelected.dataset.value ?? 0
    } else {
      let select = row.querySelector('select');
      return select.options[select.options.selectedIndex].value??0
    }
  }

  createRow(res) {
    res = {
      multiplier: 10,
      baseUnit: this.$baseUnit.selectedOptions[0].innerText
    };
    let row = (new createElement()).tag('div').attr('class', 'row').build();
    let selector = this.$selector.cloneNode(true);

    let multiplier = (new createElement()).attr('type', 'number').tag('input').attr('value', res.multiplier).build();
    let baseUnit = (new createElement()).tag('div').attr('class', 'base-unit').text(res.baseUnit).build();
    let del = (new createElement()).tag('div').attr('class', 'del').build();

    row.append(selector);
    row.append(multiplier);
    row.append(baseUnit);
    row.append(del);

    this.$rows.append(row)


  }

}