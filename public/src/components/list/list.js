import './list.scss';
import {$, post, popup} from '../../common';

export default function list() {
  // debugger;
  $('html').ready(function () {

    const table = $('.custom-list')[0]
    if (!table)return false
    const customList__wrapper = table.closest('.custom-list__wrapper')
    const contenteditable = $('[contenteditable]')
    const headers = table.querySelectorAll('.head')
    const sortables = table.querySelectorAll('[data-sort]')
    const inputs = $(table).findAll('.head input')
    const ids = $(table)[0].querySelectorAll('.id:not(.head')
    const modelName = customList__wrapper.dataset['model']
    const rows = []

    $(customList__wrapper).on('click', handleClick.bind(this));
    $(customList__wrapper).on('keyup', handleKeyUp.bind(this));

    /// DEBOUNCE
    const debounce = (fn, time = 700) => {
      let timeout;
      return function () {
        const functionCall = () => fn.apply(this, arguments);
        clearTimeout(timeout);
        timeout = setTimeout(functionCall, time);
      }
    }
    let debouncedInput = debounce(handleInput)


    function handleKeyUp({target}) {

      // contenteditable
      if (target.hasAttribute('contenteditable')) {
        debouncedInput(table, contenteditable, target)

       /// search
      } else if (target.closest('.head')) {
        let header = target.closest('.head')
        let index = [].findIndex.call(headers, (el, i, inputs) => {
          return el === header
        })
        search(index, target)
      }
    }

    function handleClick({target}) {

      /// create
      if (target.className === 'add-model') {
        modelCreate(modelName)

        /// delete
      } else if (
        target.className === '.del:not(.head)' ||
        target.closest('.del:not(.head)')) {
        modelDel(target.closest('.del:not(.head)'))

        /// edit
      } else if (target.className === '.edit:not(.head)' ||
        target.closest('.edit:not(.head)')) {
        let id = target.closest('.edit:not(.head)').dataset['id']
        window.location = `/adminsc/${modelName}/edit/${id}`;

        /// sort
      } else if (target.classList.contains('head')) {
        let header = target.closest('.head')
        let index = [].findIndex.call(headers, (el, i, inputs) => {
          return el === header
        })
        sortColumn(index)
      }
    }

    // DELETE
    async function modelDel(el) {
      // debugger
      let id = el.dataset['id']
      let model = modelName
      let res = await post(`/adminsc/${model}/delete`, {id})
      res = JSON.parse(res)
      if (res.msg === 'ok') {
        delView(id)
        popup.show(`id : ${id} удалено`)
      }
    }

    function delView(id) {
      let arr = $(`[data-id='${id}']`);
      [].forEach.call(arr, function (el) {
        el.remove()
      })
    }


    // CREATE
    async function modelCreate(modelName, e) {
      let res = await post(`/adminsc/${modelName}/create`, {})
      res = JSON.parse(res)
      if (res.id) {
        newRow(res.id - 1)
        // popup.show('Создано')
      }
    }

    function newRow(id) {
      let Row = [...rows[0]];
      [].forEach.call(Row, function (el) {
        let newEl = el.cloneNode(true)
        table.appendChild(newEl)
        if (['id'].includes(newEl.className)) {
          newEl.innerText = id
        } else if (!['del', 'edit', 'save'].includes(newEl.className)) {
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
      showAllRows()
      const value = input.value;

      [].forEach.call(inputs, (inp) => {
        if (inp !== input) inp.value = ''
      });

      [].forEach.call(rows, function (row) {
        const str = row[index].innerText
        const regexp = new RegExp(`${value}`, 'gi')
        if (!str.match(regexp)) {
          [].forEach.call(row, el => {
            el.style.display = 'none'
          })
        }
      });
    };

    // SORT
    function sortColumn(index) {
      // Получить текущее направление
      const direction = directions[index] || 'asc'

      // Фактор по направлению
      const multiplier = (direction === 'asc') ? 1 : -1

      const newRows = Array.from(rows)

      newRows.sort(function (rowA, rowB) {
        const cellA = rowA[index].innerHTML
        const cellB = rowB[index].innerHTML

        const a = transform(index, cellA)
        const b = transform(index, cellB)

        switch (true) {
          case a > b:
            return 1 * multiplier
          case a < b:
            return -1 * multiplier
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
      directions[index] = direction === 'asc' ? 'desc' : 'asc'

      // Добавить новую строку
      newRows.forEach(function (newRow) {
        newRow = Array.from(newRow);
        newRow.reverse();
        [].forEach.call(newRow, el => {
          headers[headers.length - 1].after(el)
        })
      });
    };

    /// get table rows array
    for (let i = 0; i < ids.length; i++) {
      let id = ids[i].dataset.id
      let row = $(table)[0].querySelectorAll(`[data-id='${id}']`)
      rows.push(row)
    }

    // Направление сортировки
    const directions = Array.from(sortables).map(function (sortable) {
      return ''
    });

    // Преобразовать содержимое данной ячейки в заданном столбце
    function transform(index, content) {
      // Получить тип данных столбца
      const type = sortables[index].getAttribute('data-type')
      switch (type) {
        case 'number':
          return parseFloat(content)
        case 'string':
        default:
          return content
      }
    };

    /// INPUT
    function handleInput(table, contenteditable, target) {
      if (!target.hasAttribute('contenteditable')) return false
      let modelName = table.closest('.custom-list__wrapper').dataset['model']
      let model = makeServerModel(target, modelName)
      save(model)
    }

    async function save(model) {
      let url = `/adminsc/${model.modelName}/update`
      let res = await post(url, model.model)
      res = JSON.parse(res)
      if (res.msg === 'ok') {
        popup.show('Сохранено!')
      }
    }

    function makeServerModel(el, modelName) {
      let field = el.dataset['field']
      return {
        model: {
          token: $(),
          id: el.dataset.id,
          [field]: el.innerText
        },
        modelName
      }
    }
  })

}
