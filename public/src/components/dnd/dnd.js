// import './dnd.scss'
import {$} from '../../common'

export function Dnd(cb, holderClass = '.holder') {
  let holders = $(holderClass);

  // debugger
  [].forEach.call(holders, function (h) {

    h.ondragenter = function (e) {
      e.preventDefault()
      this.classList.toggle('hover')
      return false
    }
    h.ondragleave = function (e) {
      e.preventDefault()
      this.classList.toggle('hover')
      return false
    }
    h.ondragover = function (e) {//без ondragover не работает drop
      e.preventDefault()
      return false;
    }
    h.ondrop = function (e) {
      e.preventDefault()
      debugger
      // if (e.target?.dataset?.morphOneormany === 'one'){
      // if (true){
      //   e.dataTransfer.files = e.dataTransfer.files.length = 1
      // }
      cb(e.dataTransfer.files, e.target)
    }
  })

}