import './counter.scss'
import Cookie from "../cookie/new/cookie";

export default class Counter {
  constructor() {
    // debugger
    this.second = 1;
    this.minute = 60 * this.second;
    this.hour = 60 * this.minute;
    this.day = 24 * this.hour;

    this.minutes = 60 * this.second;
    this.hours = 60 * this.minute;
    this.days = 24 * this.hour;

    // this.diff = (24 * 60 * 60) + (23 * 60 * 60) + (58 * 60) + (58)
    this.cookie = new Cookie()
  }

  start() {
    // debugger
    let time = 3 * this.minute;
    let now = (new Date).getTime();
    this.expires = now/1000 + time;

    if (!this.cookie.cookie.get_cookie('cartCounter')) {
      this.cookie.cookie.set_cookie('cartCounter', this.expires);
      this.dif = this.expires
    } else {
      let expire = +this.cookie.cookie.get_cookie('cartCounter');
      this.dif = (expire - now)/1000
    }
  }

  cartRemove() {
    this.cookie.cookie.set_cookie('cartCounter', expires)
  }

  showCounter(el) {

    this.getFormattedDiff();
    el.querySelector('.h').innerText = this.hours;
    el.querySelector('.m').innerText = this.minutes;
    el.querySelector('.s').innerText = this.seconds;

    // this.diff
    this.cookie.cookie.set_cookie('cartCounter', this.expires)
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

  getH() {
    return ((this.diff - msecDays) / 3600) | 0;
  }


  getFormattedDiff() {
    // function timer() {
    this.days = (this.dif / this.day) | 0;
    let msecDays = this.days * this.day;
    this.hours = ((this.dif - msecDays) / 3600) | 0;
    let msecHours = this.hours * this.hour;
    this.minutes = ((this.dif - msecDays - msecHours) / 60) | 0;
    let msecMinutes = this.minutes * 60;
    this.seconds = (this.dif - msecDays - msecHours - msecMinutes) | 0;
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
