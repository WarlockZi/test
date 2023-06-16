import {$, post} from "../../common";
import SelectNew from "../../components/select/SelectNew";

export default class PropertyTable {
  constructor($el) {
    this.$el = $el;
    this.$rows = this.$el.querySelector('.rows');
    this.rows = this.$el.querySelectorAll('.rows>.row');
    this.$addBtn = this.$el.querySelector('.add-property');
    this.setup()
  }

  setup() {
    if (this.$addBtn) this.$addBtn.onclick = this.newRow.bind(this);

    this.rows.forEach((row) => {
      if (!row.classList.contains('none')) {
        new SelectNew($(row).find('[custom-select]'))
      }
    });

    this.$rows.addEventListener('customSelect.changed', this.propertyChange.bind(this))
  }

  async propertyChange(obj) {
    {
      let data = this.dto();
      data.morphed.old_id = obj.detail.prev.value;
      data.morphed.new_id = obj.detail.next.value;
      let res = await post(`/adminsc/product/changeVal`, data)
    }
  }

  dto(obj) {
    return {
      category_id: this.$el.dataset.id,
      morphed: {
        old_id: +obj.detail.prev.value,
        new_id: +obj.detail.next.value
      }
    }
  }

  newRow() {
    let $clone = this.$rows.querySelector('.none .row').cloneNode(true);
    new SelectNew($($clone).find('[custom-select]'));
    this.$rows.append($clone)
  }


}