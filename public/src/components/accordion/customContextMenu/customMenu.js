import {$} from "../../../common";

export default function showCustomMenu(e) {
  $remove()
  let el = e.target
  el.append(render(e))
  el.addEventListener('mouseleave', $remove.bind(null, this),true)

}

function $remove() {
  let updates = document.querySelectorAll('.accordion .update')
  updates.forEach(el => el.remove())


}

function render(e) {
  let div = document.createElement('a')
  let id =  e.target.dataset.id??e.target.getAttribute('for')
  div.classList.add('update')
  div.href = `/adminsc/test/update/${id}`
  // div.innerText = 'Изменить'
  return div
}