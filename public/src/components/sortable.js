import Sortable from 'sortablejs'
import {$} from '../common'
import {_question} from "../Test/model/question";

export let sortable = {

    connect: (selector) => {
        let el = $(selector).el[0];
        if (el) {
            let sortable = Sortable.create(el, {
                animation: 150,
                onEnd: function (evt) {
                let questions = _question.questions()
                    _question.sort(evt.newIndex)
                    for (let i = 0; i<evt.newIndex; i++){

                    }
                    // alert(evt.oldIndex)
                    // alert(evt.newIndex)
                },
            })
        }
    }
}