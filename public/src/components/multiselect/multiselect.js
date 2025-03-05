import './multiselect.scss'
import {$} from '../../common'

export default function multiselect() {

  function getSelected(){
    if (multi){
      let selected = [].map.call(multi, function (select) {
        let chips = select.querySelectorAll('.chip-wrap');
        let objs = [].map.call(chips, function (chip) {
          return chip.dataset.id;
        })
        let obj = {}
        obj.field =  select.dataset.field
        obj.ids = objs
        return obj
      })
    }
    // debugger
  }

  let multi = $('[multi-select] ')
  if (multi) {

    [].forEach.call(multi, function (select) {

      select.addEventListener('click', handleClick, false)
      select.addEventListener('blur', handleBlur, false)

      function handleBlur({target}) {
        let show = $(this).find('.show')
        if (show) {
          show.classList.remove('show')
        }
      }

      function handleClick({target}) {
        let multi = target.closest('[multi-select]')
// открыть выбор элементов
        if (target.closest('.arrow')||['chip-wrap'].includes(target.className))  {
          // let multiselect = target.closest('[multi-select] ')
          let ul = multi.querySelector('ul')
          ul.classList.toggle('show')

// нажатие по крестику чипа
        } else if (['view.components.Builders.TableBuilder.del'].includes(target.className)) {
          let id = target.closest('.chip').dataset.id
          toggleBackground(id)
          let chip = target.closest('.chip')
          chip.remove()

// выбор элемента, проверка существования чипа и его добавление
        } else if (target.tagName.toLowerCase() === 'label') {
          let id = target.dataset.id;
          // let m = target.closest('[multi-select] ')
          let chips = multi.querySelectorAll('.chip');
          let exist = [].some.call(chips, (chip) => {
            return chip.dataset.id === id
          })

          let wrap = $(multi).find('.chip-wrap')
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
          // let multi = target.closest('[multi-select] ')
          $(multi).find(`label[data-id='${id}']`).classList.remove('selected')
        }

        function createChip(id) {
          let chip = document.createElement('div')
          chip.classList.add('chip')
          chip.innerText = target.innerText
          chip.dataset['id'] = id

          let del = document.createElement('div')
          del.classList.add('view.components.Builders.ListBuilder.del')
          del.innerText = 'X'

          chip.append(del)

          return chip
        }
      }
    })
  }
}