import './dnd.scss'
import {$} from '../../common'

export default class DragNDrop {
  constructor(el, cb, hoverSelector = 'dndhover', allFiles = true) {

    el.ondragenter = el.ondragleave = function (hoverSelector, e) {
      e.preventDefault()
      e.target.classList.toggle(hoverSelector)
      return false
    }.bind(null, hoverSelector)

    el.ondragover = function (e) {//без ondragover не работает drop
      e.preventDefault()
      return false;
    }

    el.ondrop = function (hoverSelector, e) {
      e.preventDefault()
      e.target.classList.toggle(hoverSelector)
      // debugger
      if (allFiles) {
        cb(e.dataTransfer.files)
      } else {
        cb(e.dataTransfer.files[0])
      }
    }.bind(null, hoverSelector)
  }

}