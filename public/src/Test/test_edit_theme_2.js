import './test_edit_theme_2.scss'
import {_answer} from "./model/answer";
import {$} from "../common";

$('.answer__create-button').on('click', function (e){
    let button = e.target
    let newAnswer = $(button.parentNode).find('.answer__create')
    let clone = newAnswer.cloneNode(true)
    clone.style.display = 'flex'
    newAnswer.after(clone)

    if (_answer.create){
        let create__answerButton = 0
    }
})
