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

    this.$rows.addEventListener('customSelect.changed', this.propertyChange.bind(this));
    this.$rows.addEventListener('click', this.handleClick.bind(this))
  }

  async handleClick({target}) {
    {
      if (target.classList.contains('del')) {
        this.deleteRow(target)
      } else if (target.classList.contains('edit')) {
        this.editProperty(target)
      }
    }
  }

  async editProperty(target) {
    let id = target.closest('.row').querySelector('[select-new]').dataset.value;
   location.href = `/adminsc/property/edit/${id}`
  }

  async deleteRow(target) {
    let $row = target.closest('.row');
    let $selector = $($row).find('[select-new]');
    let id = +$selector.dataset.value;
    let data = this.dto();
    data.morphed.new_id = 0;
    data.morphed.old_id = id;
    let res = await post(`/adminsc/category/changeProperty`, data);
    if (res?.ok) $row.remove()
  }

  async propertyChange(obj) {
    {
      let data = this.dto(obj);
      let res = await post(`/adminsc/category/changeProperty`, data)
    }
  }

  dto(obj = {}) {
    return {
      category_id: this.$el.closest(`[data-model="category"]`).dataset.id,
      morphed: {
        old_id: +obj?.detail?.prev?.value,
        new_id: +obj?.detail?.next?.value
      }
    }
  }

  newRow() {
    let $clone = this.$rows.querySelector('.none .row').cloneNode(true);
    new SelectNew($($clone).find('[custom-select]'));
    this.$rows.append($clone)
  }


}