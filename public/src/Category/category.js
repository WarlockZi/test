import {$, slider, scrollToTop} from '../common';

export default class Categrory {
    constructor() {
        this.category = $('.category').first();
        if (this.category) this.init();
        this.category.addEventListener('click', this.handleClick.bind(this))



    }
    handleClick({target}){
        if (target.classList.contains('blue-button')){
            this.blueButtonClicked(target)
        }
    }
    blueButtonClicked(target){
        let greenButtonWrap = target.closest('.to-cart').querySelector('.green-button-wrap')
        greenButtonWrap.style.display = 'flex'
        target.style.display = 'none'

    }

    init() {
        // slider();

        let hoist = $('.hoist').first();
        if (hoist) hoist.onclick = function () {
            scrollToTop();
        };

        // let filters = $('.filters .wrap').first();
        // if (!filters) return false;
        // filters.onchange = ({target}) => {
        //     let filter = target.closest('.filter');
        //     let input = filter.querySelector('input');
        //     let f = input.id;
        //     new callMethod(f)
        // }
    }
}

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
//
//     _init(func) {
//         this[this.func[func]]();
//     }
//
//     instore() {
//         this.instoreEls.forEach((p) => {
//             p.classList.toggle('show')
//         })
//     }
//
//     price() {
//         this.priceEls.forEach((p) => {
//             p.classList.toggle('show')
//         })
//     }
//
//
// }
