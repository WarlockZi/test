import {$} from "@src/common.js";

export default class Like{
   constructor(){
      const like = $('[table].likes').first()
      if (!like) return false
   }
}