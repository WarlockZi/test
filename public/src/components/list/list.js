import './list.scss';
import {$} from '../../common';

export default function list(selector) {
  // debugger;

  $('html').ready(function () {
    const table = $('.custom-list')[0]
    const headers = table.querySelectorAll('.head')
    const inputs = table.querySelectorAll('.head input')
    const tableBody = table.querySelectorAll('[data-id]')
    const ids = $(table)[0].querySelectorAll('.id:not(.head')
    const rows = []
    for (let i = 0; i < ids.length; i++) {
      let id = ids[i].dataset.id
      let row = $(table)[0].querySelectorAll(`[data-id='${id}']`)
      rows.push(row)
    }

    // const rows = table.querySelectorAll('td')

    // Направление сортировки
    const directions = Array.from(headers).map(function (header) {
      return ''
    });

    // Преобразовать содержимое данной ячейки в заданном столбце
    function transform(index, content) {
      // Получить тип данных столбца
      const type = headers[index].getAttribute('data-type')
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
          el.style.display ='flex'
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
            el.style.display ='none'
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


    [].forEach.call(headers, function (header, index) {
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
