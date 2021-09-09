import '../normalize.scss'

import '../components/header/header'
import '../components/footer/footer.scss'

import './test-edit.scss'
import './show'
import '../Test/test_edit_theme_2'
import '../Admin/admin.scss'

import '../components/popup.scss'
import {$, tooltip, validate} from '../common'

import {_question} from "./model/question";
import {sortable} from "../components/sortable";
import {_answer} from "./model/answer";
// import "../Admin/admin_main_menu";

function navigate(str) {
    switch (true) {
        case /\/adminsc\/test/.test(str):
            $('.module.test').addClass('activ')
            break;
    }
}

navigate(window.location.pathname)

sortable.connect('.questions')

// при создании нового теста показать пустой вопрос
let questions =  _question.questions()
if (!questions.length) {
    _question.showFirst()
}

// check('/image/create')

// раскрытие ответов
$('.question__text').on('click', _question.showAnswers)
///// question sort input validate
$('.question__delete').on('click', _question.delete)
$('.question__save').on('change', _question.save)
$('.question__sort').on('change', validate.sort)


$('.answer__delete').on('click', function () {
    _answer.del(this)
})

$('.answer__create-button').on('click', _answer.create)

$('.question__save').on('click', _question.save)

$('.question__create-button').on('click', _question.create)
