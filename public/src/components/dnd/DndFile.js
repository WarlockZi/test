import {objAndData2FormData, post} from "../../common";
import Dnd from "./dnd";

export default class DndFile{
  constructor(el){
    new Dnd(this.send,el)
    // el.addEventListener('')
  }

  async send(filelist, target){
    let path = target.dataset.path;
    let obj = objAndData2FormData({path},filelist);
    let res = await post('/adminsc/file/save', obj)

  }
}