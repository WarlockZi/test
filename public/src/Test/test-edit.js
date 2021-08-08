import '../normalize.scss'
import '../components/test-pagination/test-pagination'

import '../components/header/header'
import '../components/footer/footer.scss'

import './test-edit.scss'
import './show'
import '../Admin/admin.scss'

import '../components/popup.scss'

import {test_delete_button, validate, post, $, popup} from '../common'
import {check} from '../components/dnd/dnd'
import {_question} from './model/question'
import {_test} from './model/test'
import {appendBlock, showHidePaginBtn} from "../components/test-pagination/test-pagination";

$('.blocks .block:first-child').addClass('flex1')

$('.test_delete').on('click', _test().delete())
// new test_delete_button('.test_delete');

/// class active для admin_main_menu
if (window.location.pathname.match('/adminsc\/test/')) {
    document.querySelector('.module.test').classList.add('activ')
}


check('/image/create')
//Скрыть все вопросы
$('.block').removeClass("flex1")
//Показть первый вопрос
$('.block:first-child').addClass("flex1")

$('.a-add').on('click', aAdd)
$('.q-delete').on('click',
    (e) => {
        let res = _question().delete()
        if (res.msg === 'ok') {
            let block = e.target.closest('.block')
            block.remove()
            $(`[data-pagination = "${res.q_id}"]`).el[0].remove()
            $('[data-pagination]:first-child').addClass('nav-active')
            $('.block:first-child').addClass('flex1')
        }
    })

$('.a-del').on('click', aDelete)

$('.without-pagination').on('click', () => {
    $('.test-edit__content').el[0].classList.toggle('flex1')
    $('.test-edit__content-2').el[0].classList.toggle('flex1')
    changeTheme()

})

function setTheme() {
}


let changeTheme = () => {
}


export async function aDelete(e) {
    if ($(e.target).hasClass('a-del')) {
        if (confirm("Удалить этот ответ?")) {
            let a_id = +e.target.closest('.e-block-a').id
            let res = await post('/answer/delete', {a_id})
            res = JSON.parse(res)
            if (res.msg === 'ok') {
                let f = e.target.closest('.e-block-a')
                f.remove()
                popup.show('Ответ удален')
            }
        }
    }
}

export async function aAdd(e) {
    if ($(e.target).hasClass('a-add')) {
        let q_id = +e.target.closest('.e-block-q').id
        let res = await post('/answer/show', {q_id})
        let visibleBlock = $('.block.flex1').el[0]
        $(visibleBlock).find('.answers').insertAdjacentHTML('beforeend', res)
        let newAnswer = $(visibleBlock).find('.e-block-a:last-child')
        $(newAnswer).css('background-color', 'pink')
        setTimeout(function () {
                $(newAnswer).css('background-color', 'white')

            }, 400
        )
        $(newAnswer).on('click', aDelete)

    }
}


///// question sort input validate
$('.sort-q').on('change', validate.sort)

////////// Save событие навешиваем
// на родителя така как могут быть созданы новые блоки
$('.blocks').on('click', function (e) {
        if ($(e.target).hasClass('question__save')) {
            if (_question().save()) {
                showHidePaginBtn(res.paginationButton)
                appendBlock()
                popup.show(res.msg)
            }
        }
    }
)


// export function getAnswers(block, q_id) {
//     let answerBlocks = block.querySelectorAll('.e-block-a')
//     let answers = []
//     answerBlocks.forEach((a) => {
//         answers.push({
//             id: +a.querySelector('.checkbox').dataset['answer'],
//             answer: a.querySelector('textarea').value,
//             correct_answer: +a.querySelector('.checkbox').checked,
//             parent_question: +q_id,
//             pica: '',
//         })
//     }, q_id)
//     return answers
// }
