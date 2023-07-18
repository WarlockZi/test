import {objAndFiles2FormData, post} from "../../common";
import Dnd from "./dnd";

export default class DndFile {
  constructor(el,callback) {
    this.el = el;
    this.callback = callback;
    new Dnd(this.el, this.send.bind(this));
  }

  async send(filelist, target) {
    let path = target.closest('[dnd]').dataset.path;
    let obj = objAndFiles2FormData({path}, filelist);
    let res = await post('/adminsc/file/save', obj);
    this.callback(res?.arr?.srcs)
  }

}