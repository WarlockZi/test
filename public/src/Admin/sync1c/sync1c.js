import './sync1c.scss'
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
    let res = await post('/adminsc/sync/incclear',{})
    if (res?.arr?.success){
      document.querySelector('.sync').innerText = res.arr?.content
    }
  }
}

let incread = $(`button[func='incread']`).first()
    debugger
if (incread){
  incread.onclick = async function ({target}) {
    window.location.path = '/adminsc/sync/incread'

  }
}
// let inc = $(`button[func='inc']`).first()
// if (inc){
//   inc.onclick = async function ({target}) {
//     let res = await post('/xml/inc',{})
//   }
// }
// debugger