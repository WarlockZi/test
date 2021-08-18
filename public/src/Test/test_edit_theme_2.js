import './test_edit_theme_2.scss'
import {_answer} from "./model/answer";
import {$} from "../common";
import {_question} from "./model/question";


$('.answer__delete').on('click', function () {
    _answer.del(this)
})

$('.answer__create-button').on('click', async function (e){
    _answer.create(this)
})

$('.question__save2').on('click', function () {
    _question.save(this)
})

$('.question__create-button').on('click', function () {
    _question.create(this)
})

