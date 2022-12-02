import './dnd.scss'
import {$} from '../../common'

export default class DragNDrop {
  constructor(sel, cb, allFiles = true, hoverSelector) {
    // debugger
    this.hoverSelector = hoverSelector ?? 'dndhover'
    let els = $(sel)
    els.forEach((el)=>{
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

      el.ondrop = function (hoverSelector, e) {
        e.preventDefault()
        e.target.classList.toggle(hoverSelector)
          // debugger
        if (allFiles) {
          cb(e.dataTransfer.files)
        } else {
          cb(e.dataTransfer.files[0])
        }
      }.bind(null, this.hoverSelector)
    })


  }

}