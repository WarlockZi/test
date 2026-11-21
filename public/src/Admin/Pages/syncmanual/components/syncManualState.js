export default class SyncManualState {
  constructor() {
    this.listeners = [];
    this.state = {
      isLoading: {
        startSync: false,
        deleteFiles: false,
        loadCategories: false,
        loadProducts: false,
        loadPrices: false,
        cleanSuccessLog: false,
      },
      files: {
        import: null,
        offer: null,
      },
      logs: [],
      dndVisible: true,
    };
  }

  getState() {
    return { ...this.state };
  }

  setState(updater) {
    const newState =
      typeof updater === "function"
        ? updater(this.state)
        : { ...this.state, ...updater };

    this.state = newState;
    this.notifyListeners();
  }

  subscribe(listener) {
    this.listeners.push(listener);
    return () => {
      this.listeners = this.listeners.filter((l) => l !== listener);
    };
  }

  notifyListeners() {
    this.listeners.forEach((listener) => listener(this.state));
  }
}
