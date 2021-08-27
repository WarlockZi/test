import Sortable from 'sortablejs'
import {$} from '../common'

export let sortable = {

    connect: (selector) => {
        let el = $(selector).el[0];
        if (el) {
            let sortable = Sortable.create(el, {
                animation: 150,
                onEnd: function (evt) {
                    evt.oldIndex;
                    evt.newIndex;
                },
            })
        }
    }
}