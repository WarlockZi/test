import Component from "./Component.js";
import SyncManualState from "./syncManualState.js";
import { $, newObjAndFiles2FormData, popup, post } from "../../../../common.js";
import DndArea from "./DndArea.js";
import NoFilesMessage from "./NoFileMessage.js";
import FileIndicator from "./FileIndicator.js";
import Button from "./Button.js";
import LogDisplay from "./LogDisplay.js";

export default class SyncManualApp extends Component {
  constructor(containerSelector) {
    super();
    this.containerSelector = containerSelector;
    this.stateManager = new SyncManualState();

    // URLs
    this.urls = {
      start: "/adminsc/syncmanual/load",
      deleteFiles: "/adminsc/syncmanual/deletefiles",
      uploadFiles: "/adminsc/syncmanual/uploadFiles",
      loadCategories: "/adminsc/syncmanual/loadCategories",
      loadProducts: "/adminsc/syncmanual/loadproducts",
      loadPrices: "/adminsc/syncmanual/loadprices",
      cleanSuccessLog: "/adminsc/syncmanual/cleanSuccessLog",
    };

    // DOM Elements
    this.elements = {
      importFile: $(`${containerSelector} #import`).first(),
      offerFile: $(`${containerSelector} #offer`).first(),
      dndfile: $(`${containerSelector} .files-dnds `).first(),
      noFiles: $(`${containerSelector} #no-files`).first(),
      startSyncButton: $(`${containerSelector} #start-sync`).first(),
      deleteFilesButton: $(`${containerSelector} #delete-files`).first(),
      loadCategoriesButton: $(`${containerSelector} #load-categories`).first(),
      loadProductsButton: $(`${containerSelector} #load-products`).first(),
      loadPricesButton: $(`${containerSelector} #load-prices`).first(),
      cleanSuccessLogButton: $(
        `${containerSelector} #clean-sync-success-log`,
      ).first(),
      logStrings: $(".log-strings").first(),
    };

    // Child Components
    this.components = {};

    this.init();
  }

  init() {
    this.initializeComponents();
    this.subscribeToState();
  }

  initializeComponents() {
    // File Indicators
    this.components.importFile = new FileIndicator({
      element: this.elements.importFile,
      isVisible: false,
    });

    this.components.offerFile = new FileIndicator({
      element: this.elements.offerFile,
      isVisible: false,
    });

    // No Files Message
    this.components.noFiles = new NoFilesMessage({
      element: this.elements.noFiles,
      isVisible: true,
    });

    // DND Area
    this.components.dndArea = new DndArea({
      element: this.elements.dndfile,
      isVisible: true,
      onFilesDrop: this.handleFilesDrop.bind(this),
    });

    // Buttons
    this.components.startSyncButton = new Button({
      element: this.elements.startSyncButton,
      onClick: this.handleStartSync.bind(this),
      isDisabled: true,
    });

    this.components.deleteFilesButton = new Button({
      element: this.elements.deleteFilesButton,
      onClick: this.handleDeleteFiles.bind(this),
    });

    this.components.loadCategoriesButton = new Button({
      element: this.elements.loadCategoriesButton,
      onClick: this.handleLoadCategories.bind(this),
    });

    this.components.loadProductsButton = new Button({
      element: this.elements.loadProductsButton,
      onClick: this.handleLoadProducts.bind(this),
    });

    this.components.loadPricesButton = new Button({
      element: this.elements.loadPricesButton,
      onClick: this.handleLoadPrices.bind(this),
    });

    this.components.cleanSuccessLogButton = new Button({
      element: this.elements.cleanSuccessLogButton,
      onClick: this.handleCleanSuccessLog.bind(this),
    });

    // Log Display
    this.components.logDisplay = new LogDisplay({
      container: this.elements.logStrings,
      logs: [],
    });
  }

  subscribeToState() {
    this.unsubscribe = this.stateManager.subscribe((state) => {
      this.updateUIBasedOnState(state);
    });
  }

  updateUIBasedOnState(state) {
    this.components.startSyncButton.setLoading(state.isLoading.startSync);
    this.components.deleteFilesButton.setLoading(state.isLoading.deleteFiles);
    this.components.loadCategoriesButton.setLoading(
      state.isLoading.loadCategories,
    );
    this.components.loadProductsButton.setLoading(state.isLoading.loadProducts);
    this.components.loadPricesButton.setLoading(state.isLoading.loadPrices);
    this.components.cleanSuccessLogButton.setLoading(
      state.isLoading.cleanSuccessLog,
    );

    // Update file indicators
    if (state.files.import) {
      this.components.importFile.show();
    } else {
      this.components.importFile.hide();
    }

    if (state.files.offer) {
      this.components.offerFile.show();
    } else {
      this.components.offerFile.hide();
    }

    // Update DND area visibility
    if (!state.dndVisible) {
      this.components.dndArea.hide();
    } else {
      this.components.dndArea.show();
    }

    // Update No Files message
    if (!state.files.import && !state.files.offer) {
      this.components.noFiles.show();
    } else {
      this.components.noFiles.hide();
    }

    // Update Start button disabled state
    const canStart = state.files.import && state.files.offer;
    this.components.startSyncButton.setDisabled(!canStart);

    // Update logs
    this.components.logDisplay.logs = state.logs;
    this.components.logDisplay.render();
  }

  // ==================== EVENT HANDLERS ====================

  async handleStartSync() {
    this.stateManager.setState((state) => ({
      ...state,
      isLoading: { ...state.isLoading, startSync: true },
    }));

    try {
      const res = await post(this.urls.start);

      if (res?.loaded === "category") {
        const productsRes = await post(this.urls.loadProducts);

        if (productsRes?.loaded === "product") {
          const pricesRes = await post(this.urls.loadPrices);

          if (pricesRes?.loaded === "price") {
            const message = pricesRes?.message;
            if (message) {
              this.stateManager.setState((state) => ({
                ...state,
                logs: [...state.logs, message],
              }));
            }
          }
        }
      }
    } finally {
      this.stateManager.setState((state) => ({
        ...state,
        isLoading: { ...state.isLoading, startSync: false },
      }));
    }
  }

  async handleDeleteFiles() {
    this.stateManager.setState((state) => ({
      ...state,
      isLoading: { ...state.isLoading, deleteFiles: true },
    }));

    try {
      const res = await post(this.urls.deleteFiles);

      this.stateManager.setState((state) => ({
        ...state,
        files: {
          import: res?.importFile ? state.files.import : null,
          offer: res?.offerFile ? state.files.offer : null,
        },
        dndVisible: !res?.importFile && !res?.offerFile,
      }));
    } finally {
      this.stateManager.setState((state) => ({
        ...state,
        isLoading: { ...state.isLoading, deleteFiles: false },
      }));
    }
  }

  async handleLoadCategories() {
    this.stateManager.setState((state) => ({
      ...state,
      isLoading: { ...state.isLoading, loadCategories: true },
    }));

    try {
      await post(this.urls.loadCategories);
    } finally {
      this.stateManager.setState((state) => ({
        ...state,
        isLoading: { ...state.isLoading, loadCategories: false },
      }));
    }
  }

  async handleLoadProducts() {
    this.stateManager.setState((state) => ({
      ...state,
      isLoading: { ...state.isLoading, loadProducts: true },
    }));

    try {
      await post(this.urls.loadProducts);
    } finally {
      this.stateManager.setState((state) => ({
        ...state,
        isLoading: { ...state.isLoading, loadProducts: false },
      }));
    }
  }

  async handleLoadPrices() {
    this.stateManager.setState((state) => ({
      ...state,
      isLoading: { ...state.isLoading, loadPrices: true },
    }));

    try {
      await post(this.urls.loadPrices);
    } finally {
      this.stateManager.setState((state) => ({
        ...state,
        isLoading: { ...state.isLoading, loadPrices: false },
      }));
    }
  }

  async handleCleanSuccessLog() {
    this.stateManager.setState((state) => ({
      ...state,
      isLoading: { ...state.isLoading, cleanSuccessLog: true },
    }));

    try {
      const res = await post(this.urls.cleanSuccessLog);

      if (res?.logLines) {
        this.stateManager.setState((state) => ({
          ...state,
          logs: [],
        }));
      }
    } finally {
      this.stateManager.setState((state) => ({
        ...state,
        isLoading: { ...state.isLoading, cleanSuccessLog: false },
      }));
    }
  }

  async handleFilesDrop(files, dnd) {
    if (!files || files.length === 0) return;

    // Validation
    if (files.length > 2) {
      await popup.show("Можно только 2 файла");
      return;
    }

    for (let i = 0; i < files.length; i++) {
      if (!files[i].name.endsWith(".xml")) {
        await popup.show("Загружаемые файлы должны быть xml");
        return;
      }
    }

    // Upload files
    for (const file of files) {
      await this.uploadFile(file);
    }
  }

  async uploadFile(file) {
    const data = newObjAndFiles2FormData({}, file);
    const res = await post(this.urls.uploadFiles, data);

    this.processUploadResponse(res);
  }

  processUploadResponse(res) {
    this.stateManager.setState((state) => {
      const newFiles = { ...state.files };

      if (res?.loadedFiles?.find((f) => f === "offer")) {
        newFiles.offer = true;
      }

      if (res?.loadedFiles?.find((f) => f === "import")) {
        newFiles.import = true;
      }

      const bothFilesLoaded = newFiles.import && newFiles.offer;

      return {
        ...state,
        files: newFiles,
        dndVisible: !bothFilesLoaded,
      };
    });
  }

  destroy() {
    debugger;
    Object.values(this.components).forEach((component) => {
      if (component.destroy) {
        component.destroy();
      }
    });

    if (this.unsubscribe) {
      this.unsubscribe();
    }
  }
}
