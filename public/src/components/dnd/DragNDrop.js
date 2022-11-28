import './dnd.scss'
export default class DragNDrop {
  constructor(el, cb, allFiles = true, hoverSelector) {
    debugger
    this.hoverSelector = hoverSelector ?? 'dndhover'

    el.ondragenter = function (hoverSelector, e) {
      e.preventDefault()
      e.target.classList.toggle(hoverSelector)
      return false
    }.bind(null, this.hoverSelector)

    el.ondragleave = function (hoverSelector, e) {
      e.preventDefault()
      e.target.classList.toggle(hoverSelector)
      return false
    }.bind(null, this.hoverSelector)

    el.ondragover = function (e) {//без ondragover не работает drop
      e.preventDefault()
      return false;
    }

    el.ondrop = function (e) {
      e.preventDefault()
      if (!allFiles) {
        cb(e.dataTransfer.files[0])
      } else {
        cb(e.dataTransfer.files)
      }
    }
  }

}