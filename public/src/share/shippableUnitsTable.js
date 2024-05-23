import "./shippableTable.scss";
import {post} from "../common";
import {ael, qs} from '../constants';


export default class shippableTable {
    constructor(target) {
        if (!target) return false
        this.target = target

        this.table = target.closest('.shippable-table')
        this.table[ael]('click', this.handleClick.bind(this))

        this.blueButton = this.table[qs]('.blue-button')
        this.greenButtonWrap = this.table[qs]('.green-button-wrap')
        this.price = +this.table.dataset.price
        this.sid = this.table.dataset['1sid']
        this.total = this.table[qs]('[data-total]')
        this.formatter = new Intl.NumberFormat("ru", {
            style: "currency",
            currency: "RUB",
            minimumFractionDigits: 2
        });


        this.showButtons()
        // this.handleClick()
        this.renderSums()
    }

    showButtons() {
        if (this.getTotalCount()) {
            if (this.blueButton) {
                this.blueButton.style.display = 'none'
            }
            this.greenButtonWrap.style.display = 'flex'
        } else {
            if (this.blueButton) {
                this.blueButton.style.display = 'flex'
            }
            this.greenButtonWrap.style.display = 'none'
        }

    }

    handleClick({target}) {
        const targ = target ?? this.target
        if (targ.classList.contains('blue-button')) {
            this.showGreenButton(targ)
        } else if (targ.classList.contains('green-button')) {
            window.location.href = '/cart'
        } else if (targ.classList.contains('plus')) {
            const row = targ.closest('.unit-row')
            this.increment(row)
        } else if (targ.classList.contains('minus')) {
            const row = targ.closest('.unit-row')
            this.decrement(row)
        } else if (targ.classList.contains('input')) {
            const row = targ.closest('.unit-row')
            this.handleChange(row)
        }
        return this
    }

    increment(row) {
        row.querySelector('input').value++
        this.handleChange(row)
    }

    decrement(row) {
        const input = row.querySelector('input')
        const count = +input.value
        if (count < 2) {
            input.value = ''
        } else {
            input.value--
        }
        this.handleChange(row)
    }

    getTotalCount(target) {
        return [...this.table.querySelectorAll('input')].reduce((acc, el) => {
            return acc + (+el.value)
        }, 0)
    }

    getTotalSum() {
        return [...this.table.querySelectorAll('.sub-sum')].reduce((acc, el) => {
            return acc + (+el.value)
        }, 0)
    }

    handleChange(row) {
        const count = this.getTotalCount(row)
        this.renderSums()
        if (count === 0) this.showBlueButton()
        this.toServer(this.dto(row))

    }

    renderSums() {
        let total = [...this.table.querySelectorAll('.unit-row')].reduce((acc, row, i) => {
            const rowDto = this.rowDto(row)
            let sub_sum = +rowDto.price * +rowDto.multiplier * +rowDto.count
            if (rowDto.sub_sum)
                rowDto.sub_sum.innerText = this.formatter.format(sub_sum)
            return acc + sub_sum
        }, 0)

        if (this.total) {
            this.total.innerText = this.formatter.format(total)
        }
    }

    rowDto(row) {
        return {
            s_id: this.sid,
            price: this.price,
            unit_id: row.dataset.unitid,
            count: row.querySelector('input').value,
            multiplier: row.dataset.multiplier,
            sub_sum: row.querySelector('.sub-sum'),
        }
    }

    dto(row) {
        return {
            unit_id: row.dataset.unitid,
            count: row.querySelector('input').value,
            product_id: this.sid,
        }
    }

    toServer(dto) {
        let url = '/adminsc/orderitem/updateOrCreate'
        post(url, dto)
    }

    showBlueButton() {
        this.greenButtonWrap.style.display = 'none'
        this.greenButtonWrap.querySelector('input').value = 0
    }

    showGreenButton() {
        this.greenButtonWrap.style.display = 'flex'
        const count = +this.greenButtonWrap.querySelector('input').value
        this.greenButtonWrap.querySelector('input').value = count ? count : 1
    }

}

