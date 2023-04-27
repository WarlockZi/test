import {objAndData2FormData, post} from "../../common";
import Dnd from "./dnd";

export default class DndFile {
  constructor(el,callback) {
    this.el = el;
    new Dnd(this.send.bind(this), this.el);
    this.callback = callback
  }

  async send(filelist, target) {
    let path = target.closest('[dnd]').dataset.path;
    let obj = objAndData2FormData({path}, filelist);
    let res = await post('/adminsc/file/save', obj);

    // debugger
    this.callback(res?.arr?.srcs)
  }

}