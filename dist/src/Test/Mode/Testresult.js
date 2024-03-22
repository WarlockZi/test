import Model from "./Model";

export default class Testresult extends Model{

  constructor(){
    super()
    this.name = 'testresult'
    this.id = 0
  }

  get delDomSelector(){
    return `[data-row = '${this.id}']`
  }

}