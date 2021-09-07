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

// раскрытие ответов
$('.question__text').on('click', function (e) {
    let text = e.target
    let parent = text.parentNode.parentNode
    let answers = $(parent).find('.question__answers')
    answers.classList.toggle('height')
    answers.classList.toggle('scale')

    text.classList.toggle('rotate')
})

// check('/image/create')

///// question sort input validate
$('.question__delete').on('click', _question.delete)

$('.question__sort').on('change', validate.sort)
