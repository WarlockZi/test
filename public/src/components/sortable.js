import Sortable from 'sortablejs'
import {$} from '../common'
import {_question} from "../Test/model/question";

export let sortable = {

    connect: (selector) => {
        let el = $(selector)[0];
        if (el) {
            let sortable = Sortable.create(el, {
                animation: 150,
                onEnd: function (evt) {
                    let oldI = evt.oldIndex
                    let newI = evt.newIndex
                    if (oldI>newI){
                        let questions = _question.questions()
                        _question.sort(oldI)
                    }else{
                        let questions = _question.questions()
                        _question.sort(newI)
                    }
                },
            })
        }
    }
}