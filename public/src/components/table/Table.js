import './table.scss';
// import '../select/selectNew.scss';
import {$, debounce, post} from '../../common';
import {ael, qa, qs} from "@src/constants.js";
import SelectNew from "../../components/select/SelectNew.js";
import TableDTO from "@src/Admin/TableDTO.js";


export default class Table {
   constructor(table) {
      debugger
      this.table = table;
      this.model = table.dataset.model ?? table.closest('[data-model]')?.dataset.model;
      this.modelId = table.dataset.id ?? table.closest('[data-model]')?.dataset.id;
      this.relation = table.dataset.relation ?? null;
      this.relationType = table.dataset.relationtype ?? null;
      this.headers = $('.head');
      this.inputs = $('[data-search]');
      this.hidden = this.table[qa]('[hidden]');
      this.delUrl = `/adminsc/${this.model}/del`;
      this.updateOrCreateUrl = `/adminsc/${this.model}/updateOrCreate`

      this.table[ael]('click', this.handleClick.bind(this),true);
      this.table[ael]('keyup', debounce(this.handleKeyup.bind(this)).bind(this));
      this.table[ael]('paste', this.handlePaste.bind(this));
      this.table[ael]('customSelect.changed', this.selectChange.bind(this));
      if (!this.relation) {
         this.table[ael]('customSelect.changed', this.selectChange.bind(this));
         this.table[ael]('checkbox.changed', this.checkboxChange.bind(this));
      }
      this.setCheckboxes()
      this.setSelects()
      this.setSortables()
   }

   setDelUrl(delUrl) {
      this.delUrl = delUrl
   }

   async checkboxChange(e) {
      const dto = new TableDTO(e.target)
      await post(this.updateOrCreateUrl, dto)
   }

   async selectChange({detail}) {
      const target = detail.target
      const dto = new TableDTO(target, detail?.prev?.value)
      const res = await post(`/adminsc/${this.model}/updateorcreate`, dto)
      if (res?.arr?.detach) {
         const prevCells = this.table[qa](`[data-id='${detail.prev.value}']`)
         for (let prevCell of prevCells) {
            prevCell.dataset.id = detail.next.value
         }
      } else {
         const prevCells = this.table[qa](`[data-id='0']:not([hidden])`)
         for (let prevCell of prevCells) {
            prevCell.dataset.id = detail.next.value
         }
      }
   }

   async update(modelId, target) {
      const dto = new TableDTO(target)
      const res = await post(`/adminsc/${this.model}/updateorcreate`, dto)
   }

   async handleClick(e) {
      const target = e.target;

      /// create
      if (target.className === 'add-model') {
         this.copyEmptyRow()

         /// edit
      } else if (target.classList.contains('edit')) {
         this.edit(target)

         /// delete
      } else if (
         target.classList.contains('del') && !target.classList.contains('head')) {
         this.modelDel(target)

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
         const res = await post(this.updateOrCreateUrl, new TableDTO(target));
         if (res?.arr?.id) {
            this.newRow(res?.arr.id)
         }
      }
   }

   // DELETE
   async modelDel(target) {
      if (!confirm('Удалить?')) return;
      const dto = new TableDTO(target)
      const res = await post(this.delUrl, dto);
      if (res?.arr?.id) {
         this.delRow(res?.arr?.id)
      }
   }

   // UPDATE OR CREATE
   async updateOrcreate(target) {
      const res = await post(this.updateOrCreateUrl, new TableDTO(target))
      if (res?.arr?.success) {
         this.copyEmptyRow(target)
      } else {
         this.newRow(res?.arr.id)
      }
   }

   copyEmptyRow() {
      [].forEach.call(this.hidden, (cell) => {
         const cloneCell = cell.cloneNode(true)
         cloneCell.removeAttribute('hidden')
         this.addSelectInNewRow(cloneCell)
         const table = this.table[qa]('.custom-table')[0]
         table.append(cloneCell)
      })
   }


   newRow(id) {
      [].forEach.call(this.hidden, function (el) {
            const newEl = el.cloneNode(true);
            newEl.removeAttribute('hidden');

            this.addSelectInNewRow(newEl)
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

   addSelectInNewRow(newEl) {
      if (newEl[qs]('[select-new]')) {
         const select = newEl[qs]('[select-new]')
         this.removeUsedSelectOptions(select)
         new SelectNew(select)
      }
   }

   removeUsedSelectOptions(select) {
      const usedSelects = this.table[qa]('[data-attach]');
      [].forEach.call(usedSelects, (usedSelects) => {
         [].forEach.call(select.options, (option) => {
            if (option.value === usedSelects.dataset.id) option.remove()
         })
      })

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
      [].forEach.call(selects, (select) => {
         if (!select.parentNode.hasAttribute('hidden'))
            new SelectNew(select)
      })

   }

   setCheckboxes() {
      const checkboxes = this.table[qa]('[my-checkbox]');
      [].forEach.call(checkboxes, (checkbox) => {
         checkbox[ael]('change', this.checkboxChange.bind(this))
      });
   }
}

