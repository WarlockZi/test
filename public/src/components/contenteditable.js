import {$} from '../common'

export default function contenteditable() {
  let contenteditable = $('[contenteditable]')
  let model = $('.custom-list')[0]
  let debounceTimer

  if (model && contenteditable) {
    $(model).on('keyup', handle.bind(model, contenteditable))
  }

  function handle(e) {
    if (['NumpadEnter', 'Enter'].includes(e.code)) {
      save()
    } else {

      let text = e.target

      // inputed(e.target, contenteditable)
      // debugger
      if (debounceTimer) {
        clearTimeout(debounceTimer)
      }
      debounceTimer = setTimeout(inputed.bind(model, contenteditable), 3000)

    }
  }

  function inputed(target, contenteditable) {


    let el = $(contenteditable).find(target)
    if (el) {
      save()
      // alert(el.innerText)
    }
  }

  function save() {
    alert('dd')

  }
}

