import './list.scss';
import {$, post, debounce} from '../../common';
import MorphDTO from "../morph/MorphDTO";

const tables = $('[custom-list]');

if (tables) {
  [].forEach.call(tables, function (table) {

    const contenteditable = $('[contenteditable]');
    const headers = table.querySelectorAll('.head');
    const hidden = table.querySelectorAll('[hidden]');
    const sortables = table.querySelectorAll('[data-sort]');
    const inputs = $(table).findAll('.head input');
    const ids = getIds();

    const modelName = table.dataset.model ?? null;
    // const modelId = table.dataset.id ?? null

    const rows = fillRows();

    const WSSelects = $('[custom-select]');

    [].forEach.call(WSSelects, (select) => {
      select.onchange = customSelectChange
    });

    async function customSelectChange({target}) {
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

    function getIds() {
      let els = $(table)[0].querySelectorAll('[data-id]');
      return [].filter.call(els, function (el) {
        return el.dataset.id !== '0'
      })
    }

    $(table).on('click', handleClick.bind(this));
    $(table).on('keyup', handleKeyUp.bind(this));
    $(table).on('paste', handlePaste.bind(this));
    // $(table).on('change', handleCahnge.bind(this));

    let debouncedInput = debounce(handleInput);

    function handlePaste(e) {
      e.target.innerText = e.clipboardData.getData('text/plain');
      handleInput(table, contenteditable, e.target);
      e.target.innerText = ''
    }

    function handleKeyUp(e) {
      // debugger
      let target = e.target;
      e.cancelBubble = true;

      // contenteditable
      // debugger
      if (target.hasAttribute('contenteditable')) {
        debouncedInput(table, contenteditable, target)

        /// search
      } else if (target.closest('.head')) {
        let header = target.closest('.head');
        let index = [].findIndex.call(headers, (el, i, inputs) => {
          return el === header
        });
        search(index, target)
      }
    }

    function handleClick(e) {
      let target = e.target;

      /// create
      if (target.className === 'add-model') {
        modelCreate(target)

        /// delete
      } else if (
        target.className === '.del:not(.head)'
        || target.closest('.del:not(.head)')) {
        modelDel(target.closest('.del:not(.head)'))

        /// edit
      } else if (target.className === 'edit:not(.head)'
        || target.closest('.edit:not(.head)')) {
        e.preventDefault();
        edit(target)

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

    function edit(target) {
      // debugger
      let model = target.closest('[custom-list]').dataset.model;
      let id = target.dataset.id;
      window.location = `/adminsc/${model}/edit/${id}`;
    }

    // DELETE
    async function modelDel(el) {
      if (!confirm('Удалить?')) return;
      let id = el.dataset['id'];
      let res = await post(`/adminsc/${modelName}/delete`, {id});
      if (res) {
        delView(id)
      }
    }

    function delView(id) {
      let arr = $(`[data-id='${id}']`);
      [].forEach.call(arr, function (el) {
        el.remove()
      })
    }

    // UPDATE OR CREATE

    function createRelation(data, table, relation) {
      let parent = table.closest('.item-wrap');
      data.model = parent.dataset.model;
      data.id = parent.dataset.id;
      data.relation = relation;
      return data
    }

    function createMorph(data, table, morph) {
      let $parent = table.closest('.item-wrap');
      data.model = $parent.dataset.model;
      data.id = $parent.dataset.id;

      data.morph = new MorphDTO(table);
      // debugger
      return  data
    }


    async function modelCreate(target) {
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


    function newrow(id) {
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
    function showAllRows() {
      [].forEach.call(rows, (row) => {
        [].forEach.call(row, el => {
          el.style.display = 'flex'
        })
      })
    }

    function search(index, input) {
      showAllRows();
      const value = input.value;

      [].forEach.call(inputs, (inp) => {
        if (inp !== input) inp.value = ''
      });

      [].forEach.call(rows, function (row) {
        const str = row[index].innerText;
        const regexp = new RegExp(`${value}`, 'gi');
        if (!str.match(regexp)) {
          [].forEach.call(row, el => {
            el.style.display = 'none'
          })
        }
      });
    }
    function fillRows() {
      /// get table rows array
      let rows = [];
      for (let i = 0; i < ids.length; i++) {
        let id = ids[i].dataset.id;
        let row = $(table)[0].querySelectorAll(`[data-id='${id}']`);
        rows.push(row)
      }
      return rows
    }

// SORT
    function sortColumn(index) {

      let rows = fillRows();

      // Получить текущее направление
      const direction = directions[index] || 'asc';

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
// Направление сортировки
    const directions = Array.from(sortables).map(function (sortable) {
      return ''
    });

// Преобразовать содержимое данной ячейки в заданном столбце
    function transform(index, content) {
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
    function handleInput(table, contenteditable, target) {
      if (!target.hasAttribute('contenteditable')) return false;
      let model = makeServerModel(target, modelName);
      save(model)
    }

    async function save(model) {
      // debugger
      let url = `/adminsc/${model.modelName}/updateOrCreate`;
      let res = await post(url, model.model)
    }


    function makeServerModel(target, modelName) {
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

  })
}
