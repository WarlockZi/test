import Component from "@src/Admin/Pages/syncmanual/components/Component.js";

export default class LogDisplay extends Component {
  constructor(props) {
    super(props);
    this.container = props.container;
    this.logs = props.logs || [];

    this.init();
  }

  init() {
    this.render();
  }

  render() {
    this.container.innerText = "";
    this.logs.forEach((log) => {
      const messageDiv = document.createElement("div");
      messageDiv.classList.add("log-string");
      messageDiv.innerText = log;
      this.container.append(messageDiv);
    });
  }

  addLog(message) {
    this.logs = [...this.logs, message];
    this.render();
  }

  clear() {
    this.logs = [];
    this.render();
  }
}
