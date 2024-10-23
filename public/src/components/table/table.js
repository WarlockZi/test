import './table.scss';
import {$, debounce, post} from '../../common';

class Table {
   constructor(table) {
      this.table = table;
      this.model = table.dataset.model ?? table.closest('[data-model]')?.dataset.model;
      this.modelId = table.dataset.id ?? table.closest('[data-model]')?.dataset.id;
      this.relation = table.dataset.relation ?? null;
      this.relationModel = table.dataset.relationmodel ?? null;
      // this.field = table.dataset.field;

      this.url = `/adminsc/${this.model}/updateOrCreate`

      this.headers = $('.head');
      this.inputs = $('.head input');
      this.hidden = $('[hidden]');
      this.editable = $('[contenteditable]');
      this.sortables = $('[data-sort]');
      // this.add_button = $('.add-model');
      this.ids = this.getIds();
      this.rows = this.fillRows();
      this.WSSelects = $('[custom-select]');

      [].forEach.call(this.WSSelects, (select) => {
         select.onchange = this.customSelectChange
      });
      this.table.addEventListener('click', this.handleClick.bind(this));
      this.table.addEventListener('keyup', this.handleKeyUp.bind(this));
      this.table.addEventListener('paste', this.handlePaste.bind(this));

      this.debouncedInput = debounce(this.handleInput);
      this.directions = Array
         .from(this.sortables)
         .map(function (sortable) {
            return ''
         });
   }

   async handleClick(e) {
      const target = e.target;

      /// create
      if (target.className === 'add-model') {
         this.createModel(target)

         /// delete
      } else if (
         target.className === '.del:not(.head)'
         || target.closest('.del:not(.head)')) {
         this.modelDel(target.closest('.del:not(.head)'))

         /// edit
      } else if (target.className === 'edit:not(.head)'
         || target.closest('.edit:not(.head)')) {
         e.preventDefault();
         this.edit(target)

         // checkbox
      } else if (target.type === 'checkbox') {
         const funct = target.dataset.func
         const base_is_shippable = target.checked
         const product_1s_id = target.dataset['1sid']
         const data = {base_is_shippable, product_1s_id}
         await post(`/adminsc/${this.model}/${funct}`, data)

         /// sort
      } else if (target.classList.contains('head')
         || target.classList.contains('icon')) {
         const header = target.closest('.head');
         if (header.hasAttribute('data-sort')) {
            const index = [].findIndex.call(sortables, (el, i, inputs) => {
               return el === header
            });
            this.sortColumn(index)
         }
      }
   }

   edit(target) {
      const model = this.relation ? this.relationModel : this.model;
      const id = this.relation ? target.dataset.id : this.modelId??target.dataset.id;
      window.location = `/adminsc/${model}/edit/${id}`;
   }

   async customSelectChange({target}) {
      const wrapper = target.closest('[data-model]');
      if (!wrapper) return false

      const selected = target.options.selectedIndex;
      const id = target.options[selected].value;
      const data = {[this.field]: id, id: this.modelId};
      const res = await post(this.url, data)
   }

   getIds() {
      let els = $(this.table)[0].querySelectorAll('[data-id]');
      return [].filter.call(els, function (el) {
         return el.dataset.id !== '0'
      })
   }

   handlePaste(e) {
      e.target.innerText = e.clipboardData.getData('text/plain');
      this.handleInput(e.target);
      e.target.innerText = ''
   }

   handleKeyUp(e) {
      let target = e.target;
      e.cancelBubble = true;

      // contenteditable
      if (target.hasAttribute('contenteditable')) {
         this.debouncedInput(target)

         /// search
      } else if (target.closest('.head')) {
         const header = target.closest('.head');
         const index = [].findIndex.call(this.headers, (el, i, inputs) => {
            return el === header
         });
         this.search(index, target)
      }
   }

/// INPUT
   async handleInput(target) {
      // const model = this.makeServerModel(target);
      const data = this.createModel(target);
      const res = await post(this.url, data);
      if (res.arr.id) {
         this.newRow(res?.arr.id).bind(this)
      }
   }


   // DELETE
   async modelDel(el) {
      if (!confirm('Удалить?')) return;
      let id = el.dataset['id'];
      let res = await post(`/adminsc/${this.model}/delete`, {id});
      if (res) {
         delView(id)
      }
   }

   // UPDATE OR CREATE
   createModel(target) {
      return {
         "model": this.model,
         "id": this.modelId,
         "relation": this.relation,
         "fields": this.relationDTO(target),
      };
   }


   relationDTO(target) {
      if (!this.relation) return null
      return {
         id: target.dataset.id,
         [target.dataset.field]:target.innerText,
      }
   }

   newRow(id) {
      [].forEach.call(this.hidden, function (el) {
            const newEl = el.cloneNode(true);
            newEl.removeAttribute('hidden');

            const tableContent = $(this.table).find('.custom-table');
            tableContent.appendChild(newEl);
            if (['id'].includes(newEl.dataset.field)) {
               newEl.innerText = id
            } else if (
               !(
                  ['del', 'edit', 'save'].includes(newEl.className) ||
                  newEl.hasChildNodes('select')
               )
            ) {
               newEl.innerText = ''
            }
            newEl.dataset['id'] = id

         }.bind(this)
      );
   }


/// SEARCH
   showAllRows() {
      [].forEach.call(this.rows, (row) => {
         [].forEach.call(row, el => {
            el.style.display = 'flex'
         })
      })
   }

   search(index, input) {
      this.showAllRows();
      const value = input.value;

      [].forEach.call(this.inputs, (inp) => {
         if (inp !== input) inp.value = ''
      });

      [].forEach.call(this.rows, function (row) {
         const str = row[index].innerText;
         const regexp = new RegExp(`${value}`, 'gi');
         if (!str.match(regexp)) {
            [].forEach.call(row, el => {
               el.style.display = 'none'
            })
         }
      });
   }

   fillRows() {
      /// get table rows array
      let rows = [];
      for (let i = 0; i < this.ids.length; i++) {
         let id = this.ids[i].dataset.id;
         let row = $(this.table)[0].querySelectorAll(`[data-id='${id}']`);
         rows.push(row)
      }
      return rows
   }

// SORT
   sortColumn(index) {
      const rows = this.fillRows();
      // Получить текущее направление
      const direction = this.directions[index] || 'asc';
      // Фактор по направлению
      const multiplier = (direction === 'asc') ? 1 : -1;

      const newRows = Array.from(rows);

      newRows.sort(function (rowA, rowB) {
         const cellA = rowA[index].innerHTML;
         const cellB = rowB[index].innerHTML;

         const a = this.transform(index, cellA);
         const b = this.transform(index, cellB);

         switch (true) {
            case a > b:
               return 1 * multiplier;
            case a < b:
               return -1 * multiplier;
            case a === b:
               return 0;
         }
      });

      // Удалить старые строки
      [].forEach.call(rows, function (nodeList) {
         [].forEach.call(nodeList, el => {
            el.remove()
         })
      });

      // Поменять направление
      this.directions[index] = direction === 'asc' ? 'desc' : 'asc';

      // Добавить новую строку
      newRows.forEach(function (newRow) {
         newRow = Array.from(newRow);
         newRow.reverse();
         [].forEach.call(newRow, el => {
            this.headers[this.headers.length - 1].after(el)
         })
      });
   }


   transform(index, content) {// Преобразовать содержимое данной ячейки в заданном столбце
      if (!this.sortables[index]) return;
      const type = this.sortables[index].getAttribute('data-type');
      return type === 'number' ? parseFloat(content) : content
   }


   save(model) {
      return post(this.url, model.model)
   }


   makeServerModel(target) {
      const modelName = this.model
      return {
         model: {
            id: target.dataset.id,
            [target.dataset.field]: target.innerText
         },
         modelName
      };
   }

   delView(id) {
      const arr = $(`[data-id='${id}']`);
      [].forEach.call(arr, function (el) {
         el.remove()
      })
   }
}

const tables = $('[custom-table]');
if (tables) {
   [].forEach.call(tables, function (table) {
      new Table(table)
   })
}
export default Table