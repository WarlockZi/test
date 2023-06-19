import {$, popup, post} from "../../common";

export class Sync {
  constructor($sync) {
    this.$sync = $sync;
    this.$log_content = $($sync).find('#log_content');
    this.$sync.onclick = this.handleClick.bind(this)
  }

  async handleClick({target}) {
    if (target.classList.contains('button')) {
      let res = await post(`/adminsc/sync/${target.id}`);
      if (res?.arr?.success) {
        this.$log_content.innerText = res.arr?.content
      }
    } else {
    }
  }



  // let incclear = $(`button[func='incclear']`).first();
  // if (incclear) {
  //   incclear.onclick = async function ({target}) {
  //     let res = await post('/adminsc/sync/incclear', {});
  //     if (res?.arr?.success) {
  //       document.querySelector('.sync').innerText = res.arr?.content
  //     }
  //   }
  // }

  // let incread = $(`button[func='incread']`).first();
  // if (incread) {
  //   incread.onclick = async function ({target}) {
  //     let res = await post('/adminsc/sync/incread', {});
  //     if (res?.arr?.success) {
  //       document.querySelector('.sync').innerText = res.arr?.content
  //     }
  //   }
  // }


//   let load = $(`button[func='load']`).first();
// // debugger
//   if (load) {
//     load.onclick = async function ({target}) {
//       let res = await post('/adminsc/sync/load', {});
//       if (res?.arr?.success) {
//         document.querySelector('.sync').innerText = res.arr?.content
//       }
//     }
//   }
//
//
//   let inctruncate = $(`button[func='inctruncate']`).first();
// // debugger
//   if (inctruncate) {
//     inctruncate.onclick = async function ({target}) {
//       let res = await post('/adminsc/sync/inctruncate', {});
//       if (res?.arr?.success) {
//         popup.show(res.arr?.content)
//
//       }
//     }
//   }
// debugger


}
