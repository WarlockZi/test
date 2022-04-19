import './test-pagination.scss'
import {$} from "../../common";
import {_question} from "../../Test/model/question";
import {_answer} from "../../Test/model/answer";

// Показать первую кнопку
// $('[data-pagination]:first-child').addClass('nav-active')

$('.pagination').on('click', handleClick)

function handleClick({target}) {
    // debugger
    if (!target.dataset.pagination) return;

/// get clicked button Return if clicked is active
    if (target.classList.contains('nav-active')) return

    let active_btn = $('.pagination .nav-active')[0]
//// change active button
    active_btn.classList.remove('nav-active')
    target.classList.add('nav-active')

    let id_to_hide = active_btn.dataset['pagination']
    $(`.question[data-id="${id_to_hide}"]`).removeClass('flex1')

    let id_to_show = target.dataset['pagination']
    $(`.question[data-id="${id_to_show}"]`).addClass('flex1')
}

// //// добавление вопроса
// async function show(e) {
//     let testid = +$('.test-name').value()
//     let questCount = $("[data-pagination]").count()
//
//     let res = await post(
//         '/question/show',
//         {testid, questCount})
//     res = JSON.parse(res)
//     let Block = res.block
//     let blocks = $('.blocks')[0]
//     blocks.insertAdjacentHTML('afterBegin', Block)
//     let newBlock = $('.blocks .block:first-child')[0]
//     document.querySelector('.flex1').classList.remove('flex1')
//     $(newBlock).addClass('flex1')
//     let save_button = $(newBlock).find('.question__save')
//         $(save_button).on('click', _question().save)
// }
//
// function showHidePaginBtn(pagItem) {
//     let activePaginBtn = $('.pagination .nav-active')[0]
//     if (activePaginBtn) {
//         activePaginBtn.classList.remove('nav-active')
//     }
//     $('.add-question')[0].insertAdjacentHTML('beforeBegin', pagItem)
// }
//
// function appendBlock() {
//     let block = $('.overlay').find('.block')
//     $('.blocks').append(block)
//     $(block).addClass('flex1')
//     $('.a-add').on('click', _answer.create)
//     $('.q-delete').on('click', _question().delete())
//     $('.a-del').on('click', _answer.delete())
// }
//
function navInit() {
    let nav_buttons = $('[data-pagination]')
    if (!nav_buttons[0]) return false
    Array.from(nav_buttons).map((nav)=>{
        nav.classList.remove('nav-active')
    })
    nav_buttons[0].classList.add('nav-active')
}

// export {showHidePaginBtn, appendBlock, navInit}
export { navInit}


