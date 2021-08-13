import './test_edit_theme_2.scss'
import {_answer} from "./model/answer";
import {$} from "../common";

$('.answer__create-button').on('click', function (e){
    let button = e.target
    let answers = button.parentNode.querySelector('.answer')
    let lastAnswer = answers.querySelector
    ('.answer')
        [answers.length]
    let clone = lastAnswer.cloneNode(true)

    let sort = $(lastAnswer).find('.answer__sort').innerText
    let newSort = $(clone).find('.answer__sort')

    newSort.innerText = sort+1
    clone.style.display = 'flex'

    button.before(clone)
    clone.style.opacity = 1


    if (_answer.create){
        let create__answerButton = 0
    }
})
