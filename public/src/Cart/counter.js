import {qs} from "../constants";

export default class Counter{

    setCounter() {
        debugger
        if (!this.container[qs]('#counter')) return false
        if (this.rows.length) {
            let cartDeadline = +this.cookie.cookie.get_cookie('cartDeadline');

            const dif = cartDeadline - Date.now();
            if (dif <= 0) {
                cartDeadline = this.getDeadline();
            }
            this.cookie.cookie.set_cookie('cartDeadline', cartDeadline);

            const counter = new Counter({
                el: d[qs]('#counter'),
                durationMinutes: 30,
                callback: this.counterCallback,
                timeToLive: 30
            })
            this.counter = new Counter(this.counterEl, cartDeadline, this.counterCallback.bind(this))

        } else {
            this.counterCallback()
        }
    }
    counterReset() {
        let cartDeadline = this.getDeadline();
        this.cookie.cookie.set_cookie('cartDeadline', cartDeadline);
        if (this.counter) {
            this.counter.reset(cartDeadline)
        } else {
            this.counter = new Counter(this.counterEl, cartDeadline, this.counterCallback.bind(this));
        }
    }


}