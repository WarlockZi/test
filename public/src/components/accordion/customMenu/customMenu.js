import {$} from "../../../common";

export default function showCustomMenu(e) {
    render(e)





  //
  // if (e.type === 'dblclick') {
  //   let contextmenu = $('.accordion .update').el[0]
  //   if (contextmenu) contextmenu.remove()
  //   e.target.append(render(e))
  //   return false
  // }
  // if (e.target.tagName === 'A'&& e.type === 'click') {
  //   e.preventDefault()
  // }

}

function render(e) {
  let div = document.createElement('a')
  div.classList.add('update')
  div.href = '/adminsc/test/update/8'
  div.innerText = 'Изменить'
  return div
}