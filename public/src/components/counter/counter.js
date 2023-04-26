import './counter.scss'

export default class Counter {
  constructor() {
    this.seconds = 0;
    this.minutes = 0;
    this.hours = 0;
    this.days = 0;
    this.hour = 3600;
    this.day = 3600 * 24;
    this.diff = (24 * 60 * 60) + (23 * 60 * 60) + (58 * 60) + (58)
  }

  getDiff(end) {
    if (!end) return false;
    let date = new Date();
    let now = Math.abs(Math.round(date.getTime() / 1000));
    this.diff = end - now;
    return this.diff
  }

  setEnd(end) {
    if (!end) return false;
    let date = new Date();
    let now = Math.abs(Math.round(date.getTime() / 1000));
    this.diff = end - now;
    return this.diff
  }


  getFormattedDiff() {
    // function timer() {
      this.days = (this.diff / this.day) | 0;
      let msecDays = this.days * this.day;
      this.hours = ((this.diff - msecDays) / 3600) | 0;
      let msecHours = this.hours * this.hour;
      this.minutes = ((this.diff - msecDays - msecHours) / 60) | 0;
      let msecMinutes = this.minutes * 60;
      this.seconds = (this.diff - msecDays - msecHours - msecMinutes) | 0;
      // debugger

      this.seconds = this.seconds < 10 ? "0" + this.seconds : this.seconds;
      this.minutes = this.minutes < 10 ? "0" + this.minutes : this.minutes;
      this.hours = this.hours < 10 ? "0" + this.hours : this.hours;
      this.days = this.days < 10 ? "0" + this.days : this.days;
      this.diff = --this.diff
    }

    // timer.call(this)
    // setInterval(timer.bind(this), 1000);

}
