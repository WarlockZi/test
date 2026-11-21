export default class Component {
  constructor(props = {}) {
    this.props = props;
    this.state = {};
    this.unsubscribe = null;
  }

  setState(updater) {
    const newState =
      typeof updater === "function"
        ? updater(this.state)
        : { ...this.state, ...updater };

    this.state = newState;
    if (this.render) {
      this.render();
    }
  }

  destroy() {
    if (this.unsubscribe) {
      this.unsubscribe();
    }
  }
}
