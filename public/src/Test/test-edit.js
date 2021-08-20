import '../normalize.scss'
import '../components/test-pagination/test-pagination'

import '../components/header/header'
import '../components/footer/footer.scss'

import './test-edit.scss'
import './show'
import '../Test/test_edit_theme_2'
import '../Admin/admin.scss'

import '../components/popup.scss'
import {$, tooltip} from '../common'
import {_question} from "./model/question";

let questions = $('.questions>.question-edit').el
if (!questions.length) {
    _question.showFirst()
}

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
// $('.sort-q').on('change', validate.sort)


//
// import {validate, $, popup} from '../common'
// import {check} from '../components/dnd/dnd'
//
// import {_question} from './model/question'
// import {_test} from './model/test'
// import {appendBlock, showHidePaginBtn} from "../components/test-pagination/test-pagination";
// import {_answer} from "./model/answer";
//
//
// // let newAnser = $('.answer__create')
//

//
// // _question().showFirst()
// // $('.test_delete').on('click', _test.delete)
//
// /// class active для admin_main_menu
// if (window.location.pathname.match('/adminsc\/test/')) {
//     document.querySelector('.module.test').classList.add('activ')
// }


// $('.a-add').on('click', _answer.create)
// $('.a-del').on('click', _answer.delete)
//
// $('.q-delete').on('click',
//     (e) => {
//         let res = _question().delete()
//         if (res.msg === 'ok') {
//             let block = e.target.closest('.block')
//             block.remove()
//             $(`[data-pagination = "${res.q_id}"]`).el[0].remove()
//             $('[data-pagination]:first-child').addClass('nav-active')
//             $('.block:first-child').addClass('flex1')
//         }
//     }
// )

// toggleTheme()

// $('.without-pagination').on('click', () => {
//     toggleTheme()
// })
//
// function toggleTheme() {
//     $('.test-edit__content').el[0].classList.toggle('flex1')
//     $('.test-edit__content-2').el[0].classList.toggle('flex1')
// }

////////// Save событие навешиваем
// на родителя так  как могут быть созданы новые блоки
// $('.blocks').on('click', function (e) {
//         if ($(e.target).hasClass('question__save')) {
//             if (_question().save()) {
//                 showHidePaginBtn(res.paginationButton)
//                 appendBlock()
//                 popup.show(res.msg)
//             }
//         }
//     }
// )


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
