import "./shippableTable.scss";
import {post} from "../common";

export default function handleShippableUnitsTableClick({target}) {

    const table = new shippableTable(target)
}

class shippableTable {
    constructor(target) {
        if (!target) return false
        this.target = target

        this.table = target.closest('.shippable-table')

        this.greenButtonWrap = this.table.querySelector('.green-button-wrap')
        this.price = +this.table.dataset.price
        this.sid = this.table.dataset['1sid']
        this.total = this.table.querySelector('[data-total]')
        this.formatter = new Intl.NumberFormat("ru", {
            style: "currency",
            currency: "RUB",
            minimumFractionDigits: 2
        });
        const greenButton = this.table.querySelector('.green-button')
        if (greenButton) {
            greenButton.addEventListener('click', function () {
                window.location.href = '/cart'
            })
        }

        this.handleClick()
        this.renderSums()
    }

    handleClick() {
        const target = this.target
        const row = target.closest('.unit-row')
        if (target.classList.contains('blue-button')) {
            this.showGreenButton(target)
        } else if (target.classList.contains('plus')) {
            this.increment(row)
        } else if (target.classList.contains('minus')) {
            this.decrement(row)
        } else if (target.classList.contains('input')) {
            this.handleChange(row)
        }
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
        post('/adminsc/orderitem/updateOrCreate', dto)
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

