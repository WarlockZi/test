import {$, scrollToTop} from '../common';
import handleShippableUnitsTableClick from "../share/shippableUnitsTable";
import hoist from "../share/hoist";

export default class Categrory {
    constructor() {
        this.category = $('.category').first();
        if (!this.category) return false
        this.category.addEventListener('click', handleShippableUnitsTableClick.bind(this))
    }



}
// let filters = $('.filters .wrap').first();
// if (!filters) return false;
// filters.onchange = ({target}) => {
//     let filter = target.closest('.filter');
//     let input = filter.querySelector('input');
//     let f = input.id;
//     new callMethod(f)
// }
// class callMethod {
//     constructor(func) {
//         this.instoreEls = document.querySelectorAll(`.product[data-instore='0']`);
//         this.priceEls = document.querySelectorAll(`.product[data-price='0']`);
//         this.func = {
//             instore,
//             price,
//         };
//         this._init(func);
//     }
//     _init(func) {
//         this[this.func[func]]();
//     }
//     instore() {
//         this.instoreEls.forEach((p) => {
//             p.classList.toggle('show')
//         })
//     }
//     price() {
//         this.priceEls.forEach((p) => {
//             p.classList.toggle('show')
//         })
//     }
// }
