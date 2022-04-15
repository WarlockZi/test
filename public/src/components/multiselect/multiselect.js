import './multiselect.scss'
import {$} from '../../common'

export default function multiselect() {

  let PHPmultiselect = $('.multiselect')
  if (PHPmultiselect) {

    [].forEach.call(PHPmultiselect, function (select) {

      select.addEventListener('click', handleClick, false)
      select.addEventListener('blur', handleBlur, false)

      function handleBlur({target}) {
        let show = $(this).find('.show')
        if (show) {
          show.classList.remove('show')
        }
      }

      function handleClick({target}) {
// открыть выбор элементов
        if (target.closest('.wrap') && target.tagName.toLowerCase() === 'svg') {
          let multiselect = target.closest('.multiselect')
          let ul = multiselect.querySelector('ul')
          ul.classList.toggle('show')

// нажатие по крестику чипа
        } else if (['del'].includes(target.className)) {
          let id = target.closest('.chip').dataset.id
          toggleBackground(id)
          let chip = target.closest('.chip')
          chip.remove()

// выбор элемента, проверка существования чипа и его добавление
        } else if (target.tagName.toLowerCase() === 'label') {
          let id = target.dataset.id;
          let m = target.closest('.multiselect')
          let chips = m.querySelectorAll('.chip');
          let exist = [].some.call(chips, (chip) => {
            return chip.dataset.id === id
          })

          let wrap = $(m).find('.chip-wrap')
          if (!exist) {
            target.classList.toggle('selected')
            let chip = createChip(id)
            wrap.append(chip)
          } else {
            target.classList.toggle('selected')
            wrap.querySelector(`[data-id='${id}']`).remove()
          }
        }
        function toggleBackground(id) {
          let multi = target.closest('.multiselect')
          $(multi).find(`label[data-id='${id}']`).classList.remove('selected')
        }

        function createChip(id) {
          let chip = document.createElement('div')
          chip.classList.add('chip')
          chip.innerText = target.innerText
          chip.dataset['id'] = id

          let del = document.createElement('div')
          del.classList.add('del')
          del.innerText = 'X'

          chip.append(del)

          return chip
        }
      }
    })
  }
}