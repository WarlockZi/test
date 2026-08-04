export default class index{
  constructor() {
    this.init();
  }
  async init(){
    const { default: MyChart } = await import("../../chartjs/chartjs.js");

  }
}