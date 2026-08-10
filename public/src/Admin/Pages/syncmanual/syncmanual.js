import { $, newObjAndFiles2FormData, post } from "@src/common.js";
import Dnd from "@components/dnd/dnd.js";
import "./sync_manual.scss";
import { ael } from "@src/constants.js";

export default class syncmanual {
  constructor() {
    const containerSelector = ".sync-manual";

    this.startUrl = "/adminsc/syncmanual/load";
    this.deleteFilesUrl = "/adminsc/syncmanual/deletefiles";

    this.loadCategoriesUrl = "/adminsc/syncmanual/loadCategories";
    this.loadProductsUrl = "/adminsc/syncmanual/loadProducts";
    this.loadPricesUrl = "/adminsc/syncmanual/loadPrices";

    this.cleanSuccessLogUrl = "/adminsc/syncmanual/cleanSuccessLog";

    this.importFile = $(`${containerSelector} .files-list #import`).first();
    this.offerFile = $(`${containerSelector} .files-list #offer`).first();
    this.noFiles = $(`${containerSelector} .files-list .no-files`).first();

    this.startSyncButton = $(`${containerSelector} #start-sync`).first();
    this.deleteFilesButton = $(`${containerSelector} #delete-files`).first();

    this.loadCategoriesButton = $(
      `${containerSelector} #load-categories`,
    ).first();
    this.loadProductsButton = $(`${containerSelector} #load-products`).first();
    this.loadPricesButton = $(`${containerSelector} #load-prices`).first();

    this.cleanSuccessLogButton = $(
      `${containerSelector} #clean-sync-success-log`,
    ).first();

    this.setDND();
    this.setEvents();
  }

  setEvents() {
    this.startSyncButton[ael]("click", this.start.bind(this));
    this.deleteFilesButton[ael]("click", this.deleteFiles.bind(this));

    this.loadCategoriesButton[ael]("click", this.loadCategories.bind(this));
    this.loadProductsButton[ael]("click", this.loadProducts.bind(this));
    this.loadPricesButton[ael]("click", this.loadPrices.bind(this));

    this.cleanSuccessLogButton[ael]("click", this.cleanSuccessLog.bind(this));
  }
  async cleanSuccessLog() {
    const res = await post(this.cleanSuccessLogUrl);
    if (res?.logLines) {
    }
  }
  async loadCategories() {
    const res = await post(this.loadCategoriesUrl);
  }
  async loadProducts() {
    const res = await post(this.loadProductsUrl);
  }
  async loadPrices() {
    const res = await post(this.loadPricesUrl);
  }

  start() {
    const res = post(this.startUrl);
  }
  async deleteFiles() {
    const importFile = $("#import").first();
    const offerFile = $("#offer").first();
    const importDnd = $("#importDnd").first();
    const offerDnd = $("#offerDnd").first();
    const noFiles = $(".no-files").first();

    const res = await post(this.deleteFilesUrl);
    if (!res?.importFile) {
      importFile.classList.add("none");
      importDnd.classList.remove("none");
    }
    if (!res?.offerFile) {
      offerFile.classList.add("none");
      offerDnd.classList.remove("none");
    }
    if (!res?.importFile && !res?.offerFile) {
      noFiles.classList.remove("none");
      this.startSyncButton.classList.add("disabled");
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
    this.showStartButton();
  }
  showStartButton() {
    if (
      !this.offerFile.classList.contains("none") &&
      !this.importFile.classList.contains("none")
    ) {
      this.startSyncButton.classList.remove("disabled");
    }
  }
}
