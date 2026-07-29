import { $, newObjAndFiles2FormData, post } from "@src/common.js";
import Dnd from "@components/dnd/dnd.js";
import "./sync_manual.scss";
import { ael } from "@src/constants.js";

export default class syncmanual {
  constructor() {
    this.startUrl = "/adminsc/syncmanual/load";
    const containerSelector = ".sync-manual";
    this.importFile = $(`${containerSelector} .files-list #import`).first();
    this.offerFile = $(`${containerSelector} .files-list #offer`).first();
    this.noFiles = $(`${containerSelector} .files-list .no-files`).first();
    this.button = $(`${containerSelector} .button`).first();
    this.setDND();

    this.setEvents();
  }

  setEvents() {
    this.button[ael]("click", this.start.bind(this));
  }

  start() {
    const res = post(this.startUrl);
    if (res.success) {
      alert("dd");
    }
  }
  setDND() {
    const dnds = Array.from($("[dndfile]"));

    [].forEach.call(dnds, (dnd) => {
      new Dnd(dnd, this.getCallback());
    });
  }

  getCallback() {
    return (files, dnd) => {
      if (!files) return false;

      this.render(dnd, files);
      this.toServer(dnd, files);
    };
  }

  render(dnd, files) {
    const fieldset = dnd.closest("fieldset");
    if (files[0].name === "import0_1.xml") {
      this.show("importFile", fieldset, files[0].name);
    }
    if (files[0].name === "offers0_1.xml") {
      this.show("offerFile", fieldset, files[0].name);
    }
  }
  async toServer(dnd, files) {
    if (!dnd?.dataset?.action) {
      console.log("Data-action attr is missing on dnd element");
      return false;
    }
    const url = dnd.dataset.action;
    const obj = {};
    const data = newObjAndFiles2FormData(obj, files[0]);

    const res = await post(url, data);
  }
  show(type, fieldset, name) {
    const field = this[type];
    field.classList.toggle("none");
    field.innerText = name;
    fieldset.remove();
    this.noFiles.classList.add("none");
    this.showButton();
  }
  showButton() {
    if (
      !this.offerFile.classList.contains("none") &&
      !this.importFile.classList.contains("none")
    ) {
      this.button.classList.remove("disabled");
    }
  }
}
