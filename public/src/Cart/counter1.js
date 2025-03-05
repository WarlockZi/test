
export default class Counter1 {
  constructor(el, deadLineMs, callback) {
    if (!el) return false

    this.deadline = deadLineMs;
    this.callback = callback;

    this.$days = el.querySelector('.days');
    this.$hours = el.querySelector('.hours');
    this.$minutes = el.querySelector('.minutes');
    this.$seconds = el.querySelector('.seconds');

    this.timerId = null;
    this.countdownTimer.call(this);
    this.timerId = setInterval(this.countdownTimer.bind(this), 1000);
  }

  countdownTimer() {
    const deadline = this.deadline;

    let diff = new Date(deadline) - new Date();

    if (diff <= 0) {
      clearInterval(this.timerId);
      if (this.callback) this.callback()
    }
    const days = diff > 0 ? Math.floor(diff / 1000 / 60 / 60 / 24) : 0;
    const hours = diff > 0 ? Math.floor(diff / 1000 / 60 / 60) % 24 : 0;
    const minutes = diff > 0 ? Math.floor(diff / 1000 / 60) % 60 : 0;
    const seconds = diff > 0 ? Math.floor(diff / 1000) % 60 : 0;

    this.$days.textContent = days < 10 ? '0' + days : days;
    this.$hours.textContent = hours < 10 ? '0' + hours : hours;
    this.$minutes.textContent = minutes < 10 ? '0' + minutes : minutes;
    this.$seconds.textContent = seconds < 10 ? '0' + seconds : seconds;

    this.$days.dataset.title = this.declensionNum(days, ['день', 'дня', 'дней']);
    this.$hours.dataset.title = this.declensionNum(hours, ['час', 'часа', 'часов']);
    this.$minutes.dataset.title = this.declensionNum(minutes, ['минута', 'минуты', 'минут']);
    this.$seconds.dataset.title = this.declensionNum(seconds, ['секунда', 'секунды', 'секунд'])
  }

  reset(deadline) {
    this.deadline = deadline;
    this.countdownTimer.call(this);
    this.timerId = setInterval(this.countdownTimer.bind(this), 1000);
  }

  declensionNum(num, words) {
    return words[(num % 100 > 4 && num % 100 < 20) ? 2 : [2, 0, 1, 1, 1, 2][(num % 10 < 5) ? num % 10 : 5]];
  }

}
