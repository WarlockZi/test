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

        if (target.closest('.wrap') && target.tagName.toLowerCase() === 'svg') {
          let multiselect = target.closest('.multiselect')
          let ul = multiselect.querySelector('ul')
          ul.classList.toggle('show')

        } else if (['del'].includes(target.className)) {
          let chip = target.closest('.chip')
          chip.remove()

        } else if (target.tagName.toLowerCase() === 'label') {
          let id = target.dataset.id;
          let m = target.closest('.multiselect')
          let chips = m.querySelectorAll('.chip');
          let exist = [].some.call(chips, (chip) => {
            return chip.dataset.id === id
          })
          if (!exist) {
            let wrap = $(m).find('.chip-wrap')
            let chip = createChip(id)
            wrap.append(chip)
          }
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