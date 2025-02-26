import './dnd.scss'

export default class DragNDrop {
  constructor(el, cb, hoverSelector = 'dndhover', allFiles = true) {
      // debugger
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
        cb(e.dataTransfer.files,e.target)

    }.bind(null, hoverSelector)
  }

}