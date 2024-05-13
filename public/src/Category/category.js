import {$, slider, scrollToTop} from '../common';

export default class Categrory {
    constructor() {
        this.category = $('.category').first();
        if (this.category) this.init();
        this.category.addEventListener('click', this.handleClick.bind(this))
        this.category.addEventListener('change', this.handleChange.bind(this))
    }
    handleClick({target}){
        if (target.classList.contains('blue-button')){
            this.blueButtonClicked(target)
        }
    }
    handleChange({target}){
        if (target.classList.contains('input')){
            const dto = dto(target)
            this.toServer(dto)
        }
    }
    dto(target){
        return {

        }
    }
    blueButtonClicked(target){
        const toCart = target.closest('.to-cart')
        const greenButtonWrap = toCart.querySelector('.green-button-wrap')
        const input = toCart.querySelector('input')
        greenButtonWrap.style.display = 'flex'
        target.style.display = 'none'
        input.value = 1
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
