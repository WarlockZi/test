import './sync1c.scss'
import {$, popup, post} from '../../common'

let files = $('.file').on('click', clickHandle);

function clickHandle({target}){
  let container = target.closest('.xml');
  if (!container) return false;
  let input = container.querySelector('input');
  input.value = target.innerText

}

let incclear = $(`button[func='incclear']`).first();
if (incclear){
  incclear.onclick = async function ({target}) {
    let res = await post('/adminsc/sync/incclear',{});
    if (res?.arr?.success){
      document.querySelector('.sync').innerText = res.arr?.content
    }
  }
}

let incread = $(`button[func='incread']`).first();
if (incread){
  incread.onclick = async function ({target}) {
    let res = await post('/adminsc/sync/incread',{});
    if (res?.arr?.success){
      document.querySelector('.sync').innerText = res.arr?.content
    }
  }
}


let load = $(`button[func='load']`).first();
// debugger
if (load){
  load.onclick = async function ({target}) {
    let res = await post('/adminsc/sync/load',{});
    if (res?.arr?.success){
      document.querySelector('.sync').innerText = res.arr?.content
    }
  }
}


let inctruncate = $(`button[func='inctruncate']`).first();
// debugger
if (inctruncate){
  inctruncate.onclick = async function ({target}) {
    let res = await post('/adminsc/sync/inctruncate',{});
    if (res?.arr?.success){
      popup.show(res.arr?.content)

    }
  }
}
// debugger