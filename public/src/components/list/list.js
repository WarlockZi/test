import './list.scss';
import {$} from '../../common';

export default function list(selector) {

  const table = $('.custom-list')[0]
  const headers = table.querySelectorAll('.head')
  const inputs = table.querySelectorAll('.head input')
  const tableBody = table.querySelectorAll('tbody')[0]
  const rows = table.querySelectorAll('td')
  const rowsa = table.querySelectorAll('[row]')

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
      row.classList.remove('none')
    })
  }

  function search(index, input) {
    showAllRows()
    const value = input.value;

    [].forEach.call(inputs, (inp) => {
      if (inp !== input) inp.value = ''
    });

    [].forEach.call(rows, function (row) {
      const str = row.querySelectorAll('td')[index].innerText
      const regexp = new RegExp(`${value}`, 'gi')
      if (!str.match(regexp)) {
        row.classList.add('none')
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
      const cellA = rowA.querySelectorAll('td')[index].innerHTML
      const cellB = rowB.querySelectorAll('td')[index].innerHTML

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
    [].forEach.call(rows, function (row) {
      tableBody.removeChild(row)
    });

    // Поменять направление
    directions[index] = direction === 'asc' ? 'desc' : 'asc'

    // Добавить новую строку
    newRows.forEach(function (newRow) {
      tableBody.appendChild(newRow)
    });
  };


  [].forEach.call(headers, function (header, index) {
    header.addEventListener('click', function (e) {
      if (e.target.matches('th')) {
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

}
