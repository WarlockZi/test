export default function handleShippableUnitsTableClick({target}){

    new shippableTable(target)
}

class shippableTable{
    constructor(target) {
        this.target = target

        this.table = target.closest('.shippable-table')
        this.blueButton = this.table.querySelector('.blue-button')
        this.greenButton = this.table.querySelector('.green-button')
        this.greenButtonWrap = this.table.querySelector('.green-button-wrap')
        this.handleClick()
    }

    handleClick(){
        const target = this.target
        if (target.classList.contains('blue-button')) {
            this.showGreenButton(target)
        } else if (target.classList.contains('plus')) {
            this.increment(target)
        } else if (target.classList.contains('minus')) {
            this.decrement(target)
        }
    }
    increment(target) {
        const row = target.closest('.unit-row')
        row.querySelector('input').value++
        this.handleChange(target)
    }

    decrement(target) {
        const row = target.closest('.unit-row')
        const count = row.querySelector('input').value
        if (count > 0) row.querySelector('input').value--
        this.handleChange(target)
    }

    getCount(target) {
        const greenButtonWrap = target.closest('.green-button-wrap')
        const f = greenButtonWrap.querySelectorAll('input')
        return [...greenButtonWrap.querySelectorAll('input')].reduce((acc, el) => {
            return acc + (+el.value)
        }, 0)

    }

    handleChange(target) {
        const count = this.getCount(target)
        if (
            target.classList.contains('input') ||
            target.classList.contains('plus') ||
            target.classList.contains('minus')
        ) {
            if (count === 0) this.showBlueButton(target)
            this.toServer(this.dto(target))
        }
    }

    dto(target) {
        const s_id = target.closest('[data-1sid]').dataset['1sid']
        const unit_id = target.closest('.unit-row').dataset.unitid
        const count  = target.closest('.unit-row').querySelector('input').value
        return {
            s_id,
            unit_id,
            count
        }
    }

    toServer(dto) {
        post

    }

    showBlueButton(target) {
        this.greenButtonWrap.style.display = 'none'
        this.greenButtonWrap.querySelector('input').value = 0
    }

    showGreenButton(target) {
        this.greenButtonWrap.style.display = 'flex'
        this.greenButtonWrap.querySelector('input').value = 1
    }

    getButtons(target) {
        const toCart = target.closest('.shippable-table')
        return {
            blueButton: toCart.querySelector('.blue-button'),
            greenButtonWrap: toCart.querySelector('.green-button-wrap'),
            input: toCart.querySelector('input')
        }
    }
}

