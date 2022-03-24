import './list.scss';
import {$, post, popup} from '../../common';

export default function list(selector) {
  // debugger;

  $('html').ready(function () {
    const table = $('.custom-list')[0]
    const headers = table.querySelectorAll('.head')
    const sortables = table.querySelectorAll('[data-sort]')
    const inputs = table.querySelectorAll('.head input')

    const ids = $(table)[0].querySelectorAll('.id:not(.head')
    const delButtons = $(table)[0].querySelectorAll('.del:not(.head)')

    const modelName = table.dataset['model']
    const addModelButton = $(`.add-model[data-model="${modelName}"]`)[0]
    // const delModelButton = $(`.del`)
    const rows = []
    for (let i = 0; i < ids.length; i++) {
      let id = ids[i].dataset.id
      let row = $(table)[0].querySelectorAll(`[data-id='${id}']`)
      rows.push(row)
    }

    if (addModelButton) {
      $(addModelButton).on('click', modelCreate.bind(null, modelName))
    }

    [].forEach.call(delButtons, function (el) {
      // debugger
      $(el).on('click', modelDel.bind(el))
    })

    async function modelDel(e) {
      // debugger
      let id = this.dataset['id']
      let model = this.dataset['model']
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

    async function modelCreate(modelName) {
      let res = await post(`/adminsc/${modelName}/create`, {})
      res = JSON.parse(res)
      if (res.id) {
        newRow(res.id - 1)
        popup.show('Создано')
      }
    }

    function newRow(id) {
      let Row = [...rows[0]];
      [].forEach.call(Row, function (el) {
        let newEl = el.cloneNode(true)
        table.appendChild(newEl)
        if (['id'].includes(newEl.className)) {
          newEl.innerText = id
          newEl.dataset['id'] = id
        } else if (!['del', 'edit', 'save'].includes(newEl.className)) {
          newEl.innerText = ''
          newEl.dataset['id'] = id
        }
      });
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
    // навешивает событие только на sortables
    [].forEach.call(sortables, function (header, index) {
      const className = header.className
      header.addEventListener('click', function (e) {
        if (e.target.classList.contains('head')) {
          sortColumn(index)
        }
      })
      const input = header.querySelector('input')
      if (input) {
        input.addEventListener('keyup', function (e) {
          e.stopPropagation()
          search(index, input)
        })
      }
    })

  })
}
