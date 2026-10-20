export default class index {
  constructor() {
    this.init();
  }
  async init() {
    const { default: MyChart } =
      await import("@src/Admin/Pages/index/chartjs/chartjs.js");
  }
}
