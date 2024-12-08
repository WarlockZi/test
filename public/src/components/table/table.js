import './table.scss';
// import '../select/selectNew.scss';
import {$, debounce, post} from '../../common';
import {ael} from "@src/constants.js";
import DTO from "@src/Admin/DTO.js";
import SelectNew from "../../components/select/SelectNew.js";


export default class Table {
   constructor(table) {
      this.table = table;
      this.model = table.dataset.model ?? table.closest('[data-model]')?.dataset.model;
      this.modelId = table.dataset.id ?? table.closest('[data-model]')?.dataset.id;
      this.relation = table.dataset.relation ?? null;
      this.relationModel = table.dataset.relationmodel ?? null;
      this.updateOrCreateUrl = `/adminsc/${this.model}/updateOrCreate`
      this.headers = $('.head');
      this.inputs = $('[data-search]');
      this.hidden = $('[hidden]');

      this.table[ael]('click', this.handleClick.bind(this));
      this.table[ael]('keyup', debounce(this.handleKeyup.bind(this)).bind(this));
      this.table[ael]('paste', this.handlePaste.bind(this));
      if (!this.relation) {
         this.table[ael]('customSelect.changed', this.selectChange.bind(this));
         this.table[ael]('checkbox.changed', this.checkboxChange.bind(this));
         this.setCheckboxes()
      }
         // this.setSortables()
      this.setSelects()
      this.setSortables()
   }

   async checkboxChange({target, detail}) {
      const dto = new DTO(this.modelId, target)
      await post(this.updateOrCreateUrl, dto)
   }

   async selectChange(detail) {
      const target = detail.target
      const modelId = target.parentNode?.dataset?.id
      this.update(modelId, detail.target)
   }

   async update(modelId, target) {
      const dto = new DTO(modelId, target)
      const res = await post(`/adminsc/${this.model}/updateorcreate`, dto)
   }

   async handleClick(e) {
      const target = e.target;

      /// create
      if (target.className === 'add-model') {
         this.updateOrcreate(target)

         /// edit
      } else if (target.classList.contains('edit')) {
         this.edit(target)

         /// delete
      } else if (
         target.classList.contains('del') && !target.classList.contains('head')) {
         this.modelDel(target)

         // checkbox
      } else if (target.type === 'checkbox') {

         /// sort
      } else if (target.classList.contains('head')
         || target.classList.contains('icon')) {
         const header = target.closest('.head');
         if (header.hasAttribute('data-sort')) {
            const index = [].findIndex.call(this.sortables, (el, i, inputs) => {
               return el === header
            });
            this.sortColumn(index)
         }
      }
   }

   edit(target) {
      if (target.classList.contains('head')) return false
      const model = this.relation ? this.relationModel : this.model;
      const id = this.relation ? target.dataset.id : this.modelId ?? target.dataset.id;
      window.location = `/adminsc/${model}/edit/${id}`;
   }

   getIds() {
      const els = $(this.table)[0].querySelectorAll('[data-id]');
      return [].filter.call(els, function (el) {
         return el.dataset.id !== '0'
      })
   }

   handlePaste(e) {
      e.target.innerText = e.clipboardData.getData('text/plain');
      this.handleInput(e.target);
      e.target.innerText = ''
   }



/// INPUT
   async handleKeyup({target}) {
      if (target.hasAttribute('data-search')) {
         this.search(target)
      } else if (target.hasAttribute('contenteditable')) {
         const res = await post(this.updateOrCreateUrl, new DTO(target.dataset.id, target));
         if (res?.arr?.id) {
            this.newRow(res?.arr.id)
         }
      }
   }

   // DELETE
   async modelDel(target) {
      if (!confirm('Удалить?')) return;
      const id = target.dataset['id'];
      const res = await post(`/adminsc/${this.model}/delete`, {id});
      if (res) {
         this.delRow(id)
      }
   }

   // UPDATE OR CREATE
   async updateOrcreate(target) {
      const res = await post(this.updateOrCreateUrl, this.DTO(target))
      if (res.arr.id) {
         this.newRow(res?.arr.id)
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
   search(target, iddex) {
      const rows = this.fillRows();
      [].forEach.call(rows, (row) => {
         [].forEach.call(row, el => el.style.display = 'flex')
      });

      [].forEach.call(this.inputs, (input) => {
         if (input !== target) input.value = ''
      });
      const targetHead = target.closest('.head')
      const index = [].findIndex.call(this.headers, (el) => {
         return el === targetHead
      });
      [].forEach.call(rows, function (row) {
         const str = row[index].innerText;
         const regexp = new RegExp(`${target.value}`, 'gi');
         if (!str.match(regexp)) {
            [].forEach.call(row, el => {
               el.style.display = 'none'
            })
         }
      });
   }

   fillRows() {
      const rows = [];
      const ids = this.getIds()
      for (let i = 0; i < ids.length; i++) {
         let id = ids[i].dataset.id;
         let row = $(this.table)[0].querySelectorAll(`[data-id='${id}']`);
         rows.push(row)
      }
      return rows
   }

// SORT
   sortColumn(index) {
      const rows = this.fillRows();
      const direction = this.directions[index] || 'asc';
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
      }.bind(this));

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
      }.bind(this));
   }

   transform(index, content) {// Преобразовать содержимое данной ячейки в заданном столбце
      if (!this.sortables[index]) return;
      const type = this.sortables[index].getAttribute('data-type');
      return type === 'number' ? parseFloat(content) : content
   }

   delRow(id) {
      const cells = $(`[data-id='${id}']`);
      [].forEach.call(cells, function (cell) {
         cell.remove()
      })
   }


   setSortables() {
      this.sortables = $('[data-sort]');
      this.directions = Array.from(this.sortables)
         .map(function (sortable) {
            return ''
         });
   }

   setSelects() {

         const selects = $('[select-new]:has(option)');
         [].forEach.call(selects, (select)=>{
            new SelectNew(select)
         })

   }

   setCheckboxes() {
      const checkboxes = $('[my-checkbox]');
      [].forEach.call(checkboxes, (checkbox) => {
         checkbox[ael]('change', this.checkboxChange.bind(this))
      });
   }
}

const tables = $('[custom-table]');
if (tables) {
   [].forEach.call(tables, function (table) {
      new Table(table)
   })
}
// handleKeyUp(e) {
//    e.cancelBubble = true;
//    const target = e.target;
//
//    // contenteditable
//    if (target.hasAttribute('contenteditable')) {
//       this.debouncedInput(target)
//
//       /// search
//    } else if (target.hasAttribute('data-search')) {
//       const header = target.closest('.head');
//       const index = [].findIndex.call(this.headers, (el, i, inputs) => {
//          return el === header
//       });
//       this.search(target, index)
//    }
// }