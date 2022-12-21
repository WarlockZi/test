import './dnd.scss'
import {$} from '../../common'

export default class DragNDrop {
  constructor(el, cb, hoverSelector = 'dndhover', allFiles = true) {
    // let sel = el.classList[0]

    el.ondragenter = el.ondragleave = function (hoverSelector, e) {
      e.preventDefault()
      e.target.classList.toggle(hoverSelector)
      // debugger
      return false
    }.bind(null, hoverSelector)

    el.ondragover = function (e) {//без ondragover не работает drop
      e.preventDefault()
      // debugger
      return false;
    }

    el.ondrop = function (hoverSelector, e) {
      e.preventDefault()
      e.target.classList.toggle(hoverSelector)
      // debugger

        cb(e.dataTransfer.files)

    }.bind(null, hoverSelector)
  }

}