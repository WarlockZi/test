import DragNDrop from "./DragNDrop";

export default class DragNDropMany extends DragNDrop {

  constructor(...args) {
    super(...args,'dndhover',true)
  }

}