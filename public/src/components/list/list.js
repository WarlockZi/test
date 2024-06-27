import './list.scss';
import {$, debounce, post} from '../../common';
import MorphDTO from "../morph/MorphDTO";

class List{
   constructor(table) {
      this.table = table;
      this.model = table.dataset.model
      this.contenteditable = $('[contenteditable]');
      this.headers = table.querySelectorAll('.head');
      this.hidden = table.querySelectorAll('[hidden]');
      this.sortables = table.querySelectorAll('[data-sort]');
      this.inputs = $(table).findAll('.head input');
      this.ids = this.getIds();
      this.modelName = table.dataset.model ?? null;
      this.rows = this.fillRows();
      this.WSSelects = $('[custom-select]');

      [].forEach.call(this.WSSelects, (select) => {
         select.onchange = this.customSelectChange
      });
      this.table.addEventListener('click', this.handleClick.bind(this));
      this.table.addEventListener('keyup', this.handleKeyUp.bind(this));
      this.table.addEventListener('paste', this.handlePaste.bind(this));

      this.debouncedInput = debounce(this.handleInput);
      this.directions = Array.from(this.sortables).map(function (sortable) {
         return ''
      });
   }
      async customSelectChange({target}) {
         debugger;
         // modelUpdate(this)
         let wrapper = target.closest('[data-model]');
         let model = wrapper.dataset.model;
         let modelId = wrapper.dataset.id;
         let field = wrapper.dataset.field;

         let url = `/adminsc/${model}/updateOrCreate`;
         let selected = target.options.selectedIndex;
         let id = target.options[selected].value;
         let data = {[field]: id, id: modelId};
         let res = await post(url, data)
      }
      getIds() {
         let els = $(this.table)[0].querySelectorAll('[data-id]');
         return [].filter.call(els, function (el) {
            return el.dataset.id !== '0'
         })
      }
      handlePaste(e) {
         e.target.innerText = e.clipboardData.getData('text/plain');
         this.handleInput(this.table, this.contenteditable, e.target);
         e.target.innerText = ''
      }

      handleKeyUp(e) {
         // debugger
         let target = e.target;
         e.cancelBubble = true;

         // contenteditable
         if (target.hasAttribute('contenteditable')) {
            this.debouncedInput(this.table, this.contenteditable, target)

            /// search
         } else if (target.closest('.head')) {
            let header = target.closest('.head');
            let index = [].findIndex.call(this.headers, (el, i, inputs) => {
               return el === header
            });
            this.search(index, target)
         }
      }

      handleClick(e) {
         let target = e.target;

         /// create
         if (target.className === 'add-model') {
            modelCreate(target)

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
            // const id = target.closest('[data-id]').dataset.id
            const product_1s_id = target.dataset['1sid']
            const data = {base_is_shippable, product_1s_id}
            post(`/adminsc/${this.model}/${funct}`, data)

            /// sort
         } else if (target.classList.contains('head')
            || target.classList.contains('icon')) {
            let header = target.closest('.head');
            if (header.hasAttribute('data-sort')) {
               let index = [].findIndex.call(sortables, (el, i, inputs) => {
                  return el === header
               });
               sortColumn(index)
            }
         }
      }

      edit(target) {
         // debugger
         let model = target.closest('[custom-list]').dataset.model;
         let id = target.dataset.id;
         window.location = `/adminsc/${model}/edit/${id}`;
      }

      // DELETE
      async modelDel(el) {
         if (!confirm('Удалить?')) return;
         let id = el.dataset['id'];
         let res = await post(`/adminsc/${modelName}/delete`, {id});
         if (res) {
            delView(id)
         }
      }

      delView(id) {
         let arr = $(`[data-id='${id}']`);
         [].forEach.call(arr, function (el) {
            el.remove()
         })
      }

      // UPDATE OR CREATE
      createRelation(data, table, relation) {
         let parent = table.closest('.item-wrap');
         data.model = parent.dataset.model;
         data.id = parent.dataset.id;
         data.relation = relation;
         return data
      }

      createMorph(data, table, morph) {
         let $parent = table.closest('.item-wrap');
         data.model = $parent.dataset.model;
         data.id = $parent.dataset.id;

         data.morph = new MorphDTO(table);
         // debugger
         return data
      }


      async modelCreate(target) {
         let data = {};
         data.model = target.closest('[custom-list]').dataset.model;
         data.id = 0;
         let relation = table.dataset.relation;

         if (relation) {
            data = createRelation(data, table, relation)
         }
         // debugger
         let morph = table.parentNode.dataset.morphRelation;
         if (morph) {
            data = createMorph(data, table, relation)
         }

         let res = await post(`/adminsc/${data.model}/updateOrCreate`, data);
         if (res.arr.id) {
            newrow(res.arr.id)
         }
      }


      newrow(id) {
         [].forEach.call(hidden, function (el) {
            let newEl = el.cloneNode(true);
            newEl.removeAttribute('hidden');

            let tableContent = $(table).find('.custom-list');
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

         });
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

         let rows = this.fillRows();

         // Получить текущее направление
         const direction = this.directions[index] || 'asc';

         // Фактор по направлению
         const multiplier = (direction === 'asc') ? 1 : -1;

         const newRows = Array.from(rows);

         newRows.sort(function (rowA, rowB) {
            const cellA = rowA[index].innerHTML;
            const cellB = rowB[index].innerHTML;

            const a = transform(index, cellA);
            const b = transform(index, cellB);

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
         directions[index] = direction === 'asc' ? 'desc' : 'asc';

         // Добавить новую строку
         newRows.forEach(function (newRow) {
            newRow = Array.from(newRow);
            newRow.reverse();
            [].forEach.call(newRow, el => {
               headers[headers.length - 1].after(el)
            })
         });
      }

// Преобразовать содержимое данной ячейки в заданном столбце
      transform(index, content) {
         // Получить тип данных столбца
         if (!sortables[index]) return;
         const type = sortables[index].getAttribute('data-type');
         switch (type) {
            case 'number':
               return parseFloat(content);
            case 'string':
            default:
               return content
         }
      }

/// INPUT
      handleInput(table, contenteditable, target) {
         if (!target.hasAttribute('contenteditable')) return false;
         let model = makeServerModel(target, modelName);
         save(model)
      }

      async save(model) {
         // debugger
         let url = `/adminsc/${model.modelName}/updateOrCreate`;
         let res = await post(url, model.model)
      }


      makeServerModel(target, modelName) {
         let model = target.closest('[custom-list]').dataset.model;
         let id = target.dataset.id;
         let field = target.dataset.field;
         let obj = {
            model: {
               id: target.dataset.id,
               [field]: target.innerText
            },
            modelName
         };
         return obj
      }
}

const tables = $('[custom-list]');
if (tables) {
   [].forEach.call(tables, function (table) {
      new List(table)
   })
}
