import '../components/counter/counter'
import {$, cookieRemove, getToken, post, time, formatter} from '../common'
import Counter from "../components/counter/counter";
import Cookie from "../components/cookie/new/cookie";
import Modal from "../components/Modal/modal";
import CartSuccess from "../components/Modal/modals/CartSuccess";
import CartLogin from "../components/Modal/modals/CartLogin";
import CartLead from "../components/Modal/modals/CartLead";
import handleShippableUnitsTableClick from "../share/shippableUnitsTable";
import {d, qs, qa, ael} from '../constants';

export default class Cart {
    constructor() {
        let container = $('.user-content .cart .content').first();
        if (!container) return;
        this.container = container;
        this.container.onclick = this.handleClick.bind(this);
        this.container[ael]('click', handleShippableUnitsTableClick.bind(this))

        this.model = $(this.container).find('[data-model]').dataset.model;
        this.total = d[qs]('.total span');
        this.$cartEmptyText = d[qs]('.empty-cart');
        this.$cartCount = d[qs]('.cart .count');

        this.rows = container[qa]('.row');

        this.shippable = new handleShippableUnitsTableClick(this)
        this.renderSums()

        this.cookie = new Cookie();

        if (this.rows.length) {
            let cartDeadline = +this.cookie.cookie.get_cookie('cartDeadline');
            const dif = cartDeadline - Date.now();
            if (dif <= 0) {
                cartDeadline = this.getDeadline();
            }
            this.cookie.cookie.set_cookie('cartDeadline', cartDeadline);
            this.counter = new Counter(this.counterEl, cartDeadline, this.counterCallback.bind(this))

        } else {
            this.counterCallback()
        }

        const counter = new Counter({
            el: d[qs]('#counter'),
            durationMinutes: 30,
            callback: this.counterCallback,
            timeToLive: 30
        })


        new Modal({
            button: d[qs]('#cartLead'),
            data: new CartLead(),
            callback: this.modalLeadCallback.bind(this)
        });

        new Modal({
            button: d[qs]('#cartLogin'),
            data: new CartLogin(),
            callback: this.modalLoginCallback.bind(this)
        });

        new Modal({
            button: d[qs]('#cartSuccess'),
            data: new CartSuccess(),
            callback: this.modalcartSuccessCallback.bind(this)
        });

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


    getDeadline() {
        return this.cartLifeMs + Date.now()
    }

    counterCallback() {
        cookieRemove('cartDeadline')
        this.dropCart()
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
        const cartToken = getToken();
        const res = await post('/cart/drop', {cartToken});
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
        return d[qa]('.row').length
    }

    showEmptyCart() {
        this.container.innerHTML = '';
        this.$cartEmptyText.classList.remove('none')
        this.$cartCount.classList.add('none')
    }

}