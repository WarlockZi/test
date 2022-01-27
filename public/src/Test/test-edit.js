import {CustomSelect} from "../components/select/select";
import '../components/footer/footer.scss'

import './test-edit.scss'
import './test-edit-menu.scss'
import './test'
import './show'
import '../Admin/admin'

import '../components/popup.scss'
import {$, addTooltip, navigate, dropDown} from '../common'

import {_test} from "./model/test"
import {_question} from "./model/question"
import {_answer} from "./model/answer"
import {sortable} from "../components/sortable"

import '../components/accordion/accordion'
import '../Admin/components/main-menu/admin_main_menu'

if ($("[data-question-parent-id]")){
    $(".select__wrap select").on('change', _question.changeParent)
    // debugger
    // const selWrap = $('.select__wrap select').on('click', dropDown.bind(this))
}



// закрыть открытые чекбоксы
if ($('.select').el[0]) {
    new CustomSelect('.select', {
        name: 'service_id-btn',
        defaultValue: 'Ford',
        options: [['volkswagen', 'Volkswagen'], ['ford', 'Ford'], ['toyota', 'Toyota'], ['nissan', 'Nissan']],
        onSelected(item) {
            console.log(`Выбранное значение: ${item.textContent}`);
        },
    });
}


let toggleButton = $('.test-edit__menu-toggle').el[0]

if (toggleButton){
    $(toggleButton).on('click', (e)=>{
        let toggleButton = e.target
        let wraper = toggleButton.closest('.test-edit-wrapper')
        let menu = $(wraper).find('.test-edit__accordion')
        menu.classList.toggle('open')
    })

}


// подсветка текущего теста
_test.markCurrentInMenu()

// navigate(window.location.pathname)
sortable.connect('.questions')


// при создании нового теста показать пустой вопрос
if (!_question.questions().length
  && /\/adminsc\/test\/edit/.test(window.location.pathname)) {
    _question.showFirst()
}



$('.test__update').on('click', _test.update)
$('.test-path__update').on('click', _test.update)

// $('.question__sort').on('change', validate.sort)
$('.question__save').on('click', _question.save)
$('.question__show-answers').on('click', _question.showAnswers)
$('.question__delete').on('click', _question.delete)
$('.question__create-button').on('click', _question.create)


$('.answer__delete').on('click', _answer.del)
$('.answer__create-button').on('click', _answer.create)


  let els = $('.question__save').el
// debugger
addTooltip(
  {
    els: $('.question__save').el,
    message: 'Сохранить вопросы и ответы'
})

addTooltip({
    els: $('.question__menu').el,
    message: 'Переложить в другой тест'
})
addTooltip({
    els: $('.question__delete').el,
    message: 'Удалить вопросы и ответы'
})

addTooltip({
    els: $('.question__show-answers').el,
    message: 'Показать ответы'
})

addTooltip({
    els: $('.test-edit-menu__params').el,
    message: 'Редактировать'
})

    // debugger
addTooltip({
    els: $('.question__menu').el,
    message: 'Перенести в другой тест'
})

