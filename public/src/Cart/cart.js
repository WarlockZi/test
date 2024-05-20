import '../components/counter/counter'
import {$, cookieRemove, getToken, post, time, formatter} from '../common'
import Counter from "../components/counter/counter";
import Cookie from "../components/cookie/new/cookie";
import Modal from "../components/Modal/modal";
import CartSuccess from "../components/Modal/modals/CartSuccess";
import CartLogin from "../components/Modal/modals/CartLogin";
import CartLead from "../components/Modal/modals/CartLead";
import handleShippableUnitsTableClick from "../share/shippableUnitsTable";

export default class Cart {
    constructor() {
        let container = $('.user-content .cart .content').first();
        if (!container) return;
        this.container = container;
        this.model = $(this.container).find('[data-model]').dataset.model;
        this.total = document.querySelector('.total span');
        this.$cartEmptyText = document.querySelector('.empty-cart');
        this.$cartCount = document.querySelector('.cart .count');

        this.rows = container.querySelectorAll('.row');
        this.container.onclick = this.handleClick.bind(this);
        // this.container.onchange = this.handleChange.bind(this);
        this.shippable = new handleShippableUnitsTableClick(this)
        this.renderSums()
        this.container.addEventListener('click', handleShippableUnitsTableClick.bind(this))

        this.cookie = new Cookie();
        this.counterEl = $('#counter').first();
        this.cartLifeMs = time.mMs * 30;
        if (this.counterEl) this.counterStart();

        new Modal({
            button: $('#cartLead').first(),
            data: new CartLead(),
            callback: this.modalLeadCallback.bind(this)
        });

        new Modal({
            button: $('#cartLogin').first(),
            data: new CartLogin(),
            callback: this.modalLoginCallback.bind(this)
        });

        new Modal({
            button: $('#cartSuccess').first(),
            data: new CartSuccess(),
            callback: this.modalcartSuccessCallback.bind(this)
        });

        // this.rerenderSums()
    }

    renderSums() {
        const total = [...this.container.querySelectorAll('.shippable-table')]
            .reduce((acc, table) => {
                const price = +table.dataset.price;
                [...table.querySelectorAll('.unit-row')].reduce(
                    function (acc, row) {
                        const multi = +row.dataset.multiplier
                        const count = +row.querySelector('input').value
                        const sum = multi * price * count
                        const sub_sum = row.querySelector('.sub-sum').innerText = formatter.format(sum)
                        return acc + sub_sum
                    }.bind(price), 0)
            }, 0)
    }

    async modalLeadCallback(fields, modal) {
        let name = fields.name.value;
        let phone = fields.phone.value;
        let company = fields.company.value;
        let sess = getToken();
        let res = await post('/cart/lead', {name, phone, company, sess});
        modal.close();
        if (res) {
            location.reload()
        }
    }

    async modalcartSuccessCallback(inputs, modal) {
        modal.close()
    }

    async modalLoginCallback(fields, modal) {
        let email = fields.email.value;
        let password = fields.password.value;
        let sess = getToken();
        let res = await post('/cart/login', {email, password, sess});
        modal.close();
        if (res) {
            location.reload()
        }
    }

    counterStart() {
        let rows = $(this.container).find('.row');
        if (rows) {
            let cartDeadline = +this.cookie.cookie.get_cookie('cartDeadline');
            let dif = cartDeadline - Date.now();
            if (dif >= 0) {
                this.cookie.cookie.set_cookie('cartDeadline', cartDeadline);
                this.counter = new Counter(this.counterEl, cartDeadline, this.counterCallback.bind(this))
            } else {
                let cartDeadline = this.getDeadline();
                this.cookie.cookie.set_cookie('cartDeadline', cartDeadline);
                this.counter = new Counter(this.counterEl, cartDeadline, this.counterCallback.bind(this))
            }
        } else {
            this.counterCallback()
        }
    }

    getDeadline() {
        return this.cartLifeMs + Date.now()
    }

    counterCallback() {
        this.nullifyCookie();
        this.dropCart()
    }

    nullifyCookie() {
        cookieRemove('cartDeadline')
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

    async dropCart() {
        let cartToken = getToken();
        let res = await post('/cart/drop', {cartToken});
        if (res?.arr?.ok) {
            this.showEmptyCart()
        }
    }

    orderItemDTO(target) {
        let row = target.closest('.row');
        return {
            sess: getToken(),
            product_id: row.dataset.productId
        }
    }

    getRows() {
        return [].map.call(this.rows, (row) => {
            return {
                id: row.querySelector('.name').dataset['1sid'],
                count: row.querySelector('.count').value
            }
        });
    }

    async handleClick({target}) {
        if (target.classList.contains('del')) {
            this.deleteOItem(target)
        } else if (target.classList.contains('count')) {
            this.rerenderSums();
            this.updateOItem(target)
        } else if (target.classList.contains('plus')) {
            let quantatyInput = target.closest('.unit-row').querySelector('input');
            quantatyInput.value++;
            this.updateOItem(target)
            this.rerenderSums();

        } else if (target.classList.contains('minus')) {
            let quantatyInput = target.closest('.unit-row').querySelector('input');
            if (quantatyInput.value === "0") return false
            quantatyInput.value--;
            this.updateOItem(target)
            this.rerenderSums();
        }
    }

    async deleteOItem(target) {
        let orderItemDto = this.orderItemDTO(target);
        let res = await post(`/adminsc/${this.model}/delete`, {...orderItemDto});
        if (res?.arr?.ok) {
            target.closest('.row').remove();
            if (this.countRows() < 1) this.showEmptyCart()
            this.rerenderSums()
        }
    }

    countRows() {
        return document.querySelectorAll('.row').length
    }

    showEmptyCart() {
        this.container.innerHTML = '';
        this.$cartEmptyText.classList.remove('none')
        this.$cartCount.classList.add('none')
    }

    // dto(row) {
    //     const $select = row.querySelector('[data-unitSelector]')
    //     const unit_id = $select.options[$select.selectedIndex].dataset.id
    //     return {
    //         product_id: row.closest('.row').dataset.productId,
    //         unit_id,
    //         count: row.querySelector('input').value,
    //         sess: getToken(),
    //     }
    // }

    // async updateOItem(target) {
    //     const row = target.closest('.row')
    //     let res = await post(`/adminsc/orderItem/updateOrCreate`, this.dto(row));
    // }
    //
    // handleChange({target}) {
    //     if (target.hasAttribute('data-unitSelector')) {
    //         this.updateOItem(target)
    //     }
    //     this.rerenderSums()
    // }

    // rerenderSums() {
    //     if (!this.rows.length) return false;
    //     let formatter = new Intl.NumberFormat("ru-RU", {maximumFractionDigits: 2, minimumFractionDigits: 2});
    //     let total = [].reduce.call(this.rows, (acc, row, i, rows) => {
    //         let price = +row.querySelector('.price-table').dataset.price;
    //         let count = row.querySelector('input').value;
    //
    //         const select = row.querySelector('select');
    //         // const multiplier = select.options[select.options.selectedIndex].dataset.multiplier
    //
    //         // let sum = (price * count * multiplier);
    //         // row.querySelector('.sum').innerText = formatter.format(sum).replace(/,/g, '.');
    //         // acc += sum;
    //         // return acc
    //     }, 0);
    //     this.total.innerText = formatter.format(total).replace(/,/g, '.')
    // }

}