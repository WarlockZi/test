import "./table.scss";
import { $, debounce, post } from "../../common";
import { ael, qa, qs, searchSelector } from "@src/constants.js";
import TableDTO from "@src/Admin/DTO/TableDTO.js";
import Checkbox from "@components/checkbox/checkbox.js";
import SearchableSelect from "@components/select/Factory/SearchableSelect.js";
import FieldDTO from "@src/Admin/DTO/FieldDTO.js";

export default class Table {
  constructor(table) {
    if (!table) return false;

    this.table = table;

    this.jscallbacksfile = this.table.dataset.jscallbacksfile;
    this.onLoadFile = this.table.dataset.jsonload;

    this.model =
      table.dataset.model ?? table.closest("[data-model]")?.dataset.model;
    this.modelId =
      table.dataset.id ?? table.closest("[data-model]")?.dataset.id;
    this.relation = table.dataset.relation ?? null;
    this.relationType = table.dataset.relationtype ?? null;

    this.headers = $(".head");
    this.inputs = $("[data-search]");
    this.hidden = this.table[qa]("[hidden]");

    this.delUrl = `/adminsc/${this.model}/delete`;
    this.updateOrCreateUrl = `/adminsc/${this.model}/updateOrCreate`;

    this.table[ael]("click", this.handleClick.bind(this), true);
    this.table[ael]("keyup", debounce(this.handleKeyup.bind(this)).bind(this));
    this.table[ael]("paste", this.handlePaste.bind(this));
    this.table[ael]("searchableSelect.changed", this.selectChange.bind(this));
    this.table[ael]("checkbox.changed", this.checkboxChange.bind(this));

    this.setCheckboxes();
    this.setSelects();
    this.setSortables();
    this.onLoad();
  }

  async onLoad() {
    if (!this.onLoadFile) return false;
    //  загружаем модули из build для production, тк dev берет из памяти, а prod из build
    const components = import.meta.glob("./onLoad/*.js");
    const path = "./onLoad/" + this.onLoadFile + ".js";
    const { default: OnLoad } = await components[path]();
    return new OnLoad(this);
  }

  async getCallbacks() {
    if (!this.jscallbacksfile) return false;
    //  загружаем модули из build для production, тк dev берет из памяти, а prod из build
    const components = import.meta.glob("./callbacks/*.js");
    const path = "./callbacks/" + this.jscallbacksfile + ".js";
    const { default: Callbacks } = await components[path]();
    return new Callbacks();
  }

  setDelUrl(delUrl) {
    this.delUrl = delUrl;
  }

  async checkboxChange(e) {
    // const dto = new TableDTO(e.el);
    const dto = new FieldDTO(e.currentTarget);
    await post(this.updateOrCreateUrl, dto);
  }

  async selectChange({ detail }) {
    const target = detail.el;

    const colummnJsCallback = await this.handleCallbacks(target);

    if (!colummnJsCallback) {
      const dto = new FieldDTO(target);
      const res = await post(`/adminsc/${this.model}/updateorcreate`, dto);
      if (res?.detached) {
        const prevCells = this.table[qa](
          `[data-id='${detail.prev.value}']:not([hidden])`,
        );
        for (let prevCell of prevCells) {
          prevCell.dataset.id = detail.next.value;
        }
      } else if (res.id) {
        this.setRowCellsId(target.closest("[data-id]"), res.id);
      } else {
        const prevCells = this.table[qa](`[data-id='0']:not([hidden])`);
        for (let prevCell of prevCells) {
          prevCell.dataset.id = detail.next.value;
        }
      }
    }
  }

  async update(modelId, target) {
    const dto = new FieldDTO(target);
    // const dto = new TableDTO(target);
    const res = await post(`/adminsc/${this.model}/updateorcreate`, dto);
  }

  async handleClick(e) {
    const target = e.target;

    /// create
    if (target.className === "add-model") {
      this.copyEmptyRow();

      /// edit
    } else if (target.classList.contains("edit")) {
      this.edit(target);

      /// delete
    } else if (
      target.classList.contains("del") &&
      !target.classList.contains("head")
    ) {
      this.modelDel(target);

      /// sort
    } else if (
      target.classList.contains("head") ||
      target.classList.contains("icon")
    ) {
      const header = target.closest(".head");
      if (header.hasAttribute("data-sort")) {
        const index = [].findIndex.call(this.sortables, (el, i, inputs) => {
          return el === header;
        });
        this.sortColumn(index);
      }
    }
  }

  edit(target) {
    if (target.classList.contains("head")) return false;

    const model = this.relationType ?? this.model;
    const id = this.relation
      ? target.dataset.id
      : (this.modelId ?? target.dataset.id);
    window.location = `/adminsc/${model}/edit/${id}`;
  }

  getIds() {
    const els = $(this.table)[0].querySelectorAll("[data-id]");
    return [].filter.call(els, function (el) {
      return el.dataset.id !== "0";
    });
  }

  handlePaste(e) {
    e.el.innerText = e.clipboardData.getData("text/plain");
    this.handleInput(e.el);
    e.el.innerText = "";
  }

  async handleCallbacks(target) {
    // const colummnJsCallback =
    //   target.closest("[data-jscallback]")?.dataset?.jscallback;
    const colummnJsCallback =
      target.closest("[data-jscallback]").dataset.jscallback;
    if (colummnJsCallback) {
      const cb = await this.getCallbacks();
      cb.callMethod(colummnJsCallback, [target, this]);
      return true;
    }
    return false;
  }

  /// INPUT
  async handleKeyup({ target }) {
    if (target.hasAttribute("data-search")) {
      this.search(target);
    } else if (target.hasAttribute("contenteditable")) {
      const colummnJsCallback = this.handleCallbacks(target);
      if (!colummnJsCallback) {
        const DTO = new FieldDTO(target);
        // const DTO = new TableDTO(target);
        const res = await post(this.updateOrCreateUrl, DTO);
        if (DTO.id === "0" && res?.id) {
          this.setRowCellsId(target, res?.id);
        }
      }
    }
  }

  setRowCellsId(target, id) {
    const rowCells = this.getRowCells(0);
    [].forEach.call(rowCells, (row) => {
      if (row.dataset.field === "id") {
        row.innerText = id;
      }
      row.dataset.id = id;
    });
  }
  rowFieldId(row) {
    return [].find.call(row, (cell) => cell.dataset.field === "id");
  }

  getRows() {
    const cells = this.table[qa](`[data-row]`);
    let rowId = "0";
    let newRows = [];
    let columnId = 0;
    [].map.call(
      cells,
      (cell) => {
        if (rowId === "0") {
          rowId = cell.dataset.id;
          columnId = 0;
          newRows[rowId] = [];
          newRows[rowId][columnId] = cell;
          columnId++;
        } else if (rowId === cell.dataset.id) {
          newRows[rowId][columnId] = cell;
          columnId++;
        } else {
          rowId = cell.dataset.id;
          columnId = 0;
          newRows[rowId] = [];
          newRows[rowId][columnId] = cell;
          columnId++;
        }
      },
      [rowId, newRows, columnId],
    );
    return newRows;
  }

  // DELETE
  async modelDel(target) {
    if (target.hasAttribute("disabled")) return;
    const dto = new TableDTO(target);
    if (dto?.relation?.id === "0") {
      this.removeRowCells(this.getRowCells(0));
    } else {
      if (!confirm("Удалить?")) return;

      const res = await post(this.delUrl, dto);
      if (res?.id) {
        this.removeRowCells(this.getRowCells(res?.id));
      }
    }
  }

  getRowCells(id) {
    return this.table[qa](`[data-id="${id}"]:not([hidden]):not([my-checkbox])`);
  }

  removeRowCells(sells) {
    [].forEach.call(sells, function (el) {
      el.remove();
    });
  }

  copyEmptyRow() {
    [].forEach.call(this.hidden, (cell) => {
      const cloneCell = cell.cloneNode(true);
      cloneCell.removeAttribute("hidden");

      if (cloneCell[qs]("select")) {
        this.addSelectInNewRow(cloneCell);
      }
      if (cloneCell[qs]("[my-checkbox]")) {
        this.addCheckbox(cloneCell);
      }
      const table = this.table[qa](".custom-table")[0];
      table.append(cloneCell);
    });
    this.noItemsDivToggle();
  }
  noItemsDivToggle() {
    const noItem = $(this.table).find("[data-noitems]");
    if (noItem) {
      noItem.style.visibility = "hidden";
    }
  }

  addCheckbox(cloneCell) {
    const el = cloneCell[qs]("[my-checkbox]");
    new Checkbox(el);
  }

  addSelectInNewRow(newEl) {
    const select = newEl[qs]("select");
    const cleanedSelect = this.removeUsedSelectOptions(select);
    new SearchableSelect(cleanedSelect);
  }

  removeUsedSelectOptions(select) {
    const usedSelects = this.table[qa](`[` + searchSelector + `]`);
    const ids = [].map.call(usedSelects, (usedSelect) => {
      return usedSelect.dataset.value;
    });

    [].forEach.call(ids, (id) => {
      if (id === "0") return;
      [].forEach.call(select.options, (option) => {
        if (option.value === id) option.remove();
      });
    });

    return select;
  }

  /// SEARCH
  search(target) {
    const rows = this.fillRows();
    [].forEach.call(rows, (row) => {
      [].forEach.call(row, (el) => (el.style.display = "flex"));
    });

    [].forEach.call(this.inputs, (input) => {
      if (input !== target) input.value = "";
    });
    const targetHead = target.closest(".head");
    const index = [].findIndex.call(this.headers, (el) => {
      return el === targetHead;
    });
    [].forEach.call(rows, function (row) {
      const str = row[index].innerText;
      const regexp = new RegExp(`${target.value}`, "gi");
      if (!str.match(regexp)) {
        [].forEach.call(row, (el) => {
          el.style.display = "none";
        });
      }
    });
  }

  fillRows() {
    const rows = [];
    const ids = this.getIds();
    for (let i = 0; i < ids.length; i++) {
      let id = ids[i].dataset.id;
      let row = $(this.table)[0].querySelectorAll(`[data-id='${id}']`);
      rows.push(row);
    }
    return rows;
  }

  // SORT
  sortColumn(index) {
    const rows = this.fillRows();
    const direction = this.directions[index] || "asc";
    const divider = direction === "asc" ? 1 : -1;
    const newRows = Array.from(rows);

    newRows.sort(
      function (rowA, rowB) {
        const cellA = rowA[index].innerHTML;
        const cellB = rowB[index].innerHTML;

        const a = this.transform(index, cellA);
        const b = this.transform(index, cellB);

        switch (true) {
          case a > b:
            return 1 * divider;
          case a < b:
            return -1 * divider;
          case a === b:
            return 0;
        }
      }.bind(this),
    );

    // Удалить старые строки
    [].forEach.call(rows, function (nodeList) {
      [].forEach.call(nodeList, (el) => {
        el.remove();
      });
    });

    // Поменять направление
    this.directions[index] = direction === "asc" ? "desc" : "asc";

    // Добавить новую строку
    newRows.forEach(
      function (newRow) {
        newRow = Array.from(newRow);
        newRow.reverse();
        [].forEach.call(newRow, (el) => {
          this.headers[this.headers.length - 1].after(el);
        });
      }.bind(this),
    );
  }
  getCellByDataField(row, field) {
    return row.find((cell) => cell?.dataset?.field === field);
  }
  transform(index, content) {
    // Преобразовать содержимое данной ячейки в заданном столбце
    if (!this.sortables[index]) return;
    const type = this.sortables[index].getAttribute("data-type");
    return type === "number" ? parseFloat(content) : content;
  }

  setSortables() {
    this.sortables = $("[data-sort]");
    this.directions = Array.from(this.sortables).map(function (sortable) {
      return "";
    });
  }

  setSelects() {
    const selects = this.table[qa](`[` + searchSelector + `]:has(option)`);
    [].forEach.call(selects, (select) => {
      if (!select.parentNode.hasAttribute("hidden")) {
        const options = Array.from(select[qa]("option"));
        const selected = options.find((opt) => opt.hasAttribute("selected"));
        // TODO: collect all selectid in this row and remove selected options

        new SearchableSelect(select, { selected });
        // select.remove();
      }
    });
  }

  setCheckboxes() {
    const checkboxes = this.table[qa]("[my-checkbox]");
    [].forEach.call(checkboxes, (checkbox) => {
      checkbox[ael]("change", this.checkboxChange.bind(this));
    });
  }
}
