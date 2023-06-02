import {$, createElement, post} from '../../common'

export default class Unit {
  constructor(tableClass) {
    this.$table = $(tableClass).first();
    if (!this.$table) return;

    this.productId = $('.item_wrap').first().dataset.id;

    this.$addUnit = $('.add-unit').first();
    this.$addUnit = $('.add-unit').first();
    this.$rows = $('.rows').first();
    this.$selector = $(this.$rows).find('[custom-select]');

    this.$rows.onchange = this.update.bind(this);
    this.$addUnit.onclick = this.addRow.bind(this)


  }

  async addRow() {
    let data = this.dto();
    this.createRow()
  }

  async update({target}) {
    let row = target.closest('.row');
    let data = this.dto(row);
    // let res = await post('/adminsc/unit/attachUnit', data)
    this.createRow(res)
  }

  dto(row) {
    let pivot;
    if (row) {
      let unit = $(row).find('select');
      pivot = {
        'unitId': unit.options[unit.selectedIndex].value ?? 0,
        'multiplier': $(row).find('.multiplier').innerText ?? 0,
      }
    }
    return {
      productId: this.productId,
      pivot: pivot ?? null
    }

  }

  createRow(res) {
    res = {
      multiplier: 2,
      baseUnit: 'пар'
    };
    let row = (new createElement()).tag('div').attr('class', 'row').build();
    let selector = this.$selector.cloneNode(true);

    let multiplier = (new createElement()).attr('type', 'number').tag('input').attr('class', 'multiplier').attr('value', res.multiplier).build();
    let baseUnit = (new createElement()).tag('div').attr('class', 'baseUnit').text(res.baseUnit).build();
    let del = (new createElement()).tag('div').attr('class', 'del').text('X').build();

    row.append(selector);
    row.append(multiplier);
    row.append(baseUnit);
    row.append(del);

    this.$rows.append(row)


  }

}