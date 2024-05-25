import {$, getToken, scrollToTop} from '../common';
import {ael, d, qa, qs} from '../constants';
import hoist from "../share/hoist/hoist";
import shippableTable from "../share/shippable/shippableUnitsTable";

export default class Category {
    constructor() {
        this.category = document[qs]('.category');
        if (!this.category) return false;
        this.mapShippableTables()
        this.category[ael]('click', this.handleClick.bind(this))
    }

    handleClick({target}) {
        if (target.classList.contains('.blue-button')){
            const table = target.closest('[shipable-table]')
            const firstRow = table[qs]('.unit-row')
        }
    }


    mapShippableTables() {
        [...this.category[qa]('.shippable-table')]
            .forEach((table) => {
                new shippableTable(table)
            })
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
