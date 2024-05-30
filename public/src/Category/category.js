import {ael, d, qa, qs} from '../constants';
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

