import './xml.scss'
import {$,post} from '../../common'

let files = $('.file').on('click', clickHandle)

function clickHandle({target}){
  let container = target.closest('.xml')
  if (!container) return false
  let input = container.querySelector('input')
  input.value = target.innerText

}

let incclear = $(`button[func='incclear']`).first()
if (incclear){
  incclear.onclick = async function ({target}) {
    let res = await post('/adminsc/xml/incclear',{})
  }
}
let inc = $(`button[func='inc']`).first()
if (inc){
  inc.onclick = async function ({target}) {
    let res = await post('/xml/inc',{})
  }
}
debugger
let incread = $(`button[func='incread']`).first()
if (incread){
  incread.onclick = async function ({target}) {
    window.location.path = '/adminsc/xml/incread'

  }
}