import './test-pagination.scss'
import {$} from "../../common";

let pagination = $('.pagination')[0]
let paginations = $(`[data-pagination]`)

if (pagination) {
  navInit()
  $(pagination).on('click', handleClick)
}

let next = $('#next')[0]
if (next) {

  $(next).on('click', handleNextPrev)

  let prev = $('#prev')[0]
  if (prev) {
    $(prev).on('click', handleNextPrev)
  }
}

function handleNextPrev({target}) {
  let activeQuestion = $('.question.show')[0]
  let activePagination = $(`[data-pagination].active`)[0]
  let i = paginations.indexOf(activePagination)
  if (target.id === 'prev') {
    handlePrevClick()
  } else if (target.id === 'next') {
    handleNextClick()
  }

  function handlePrevClick() {
    if (i < 1) return false
    let aimPagination = paginations[i - 1]
    toggleQuestion(aimPagination, activeQuestion)
    toggleNav(aimPagination, activePagination)
  }

  function handleNextClick() {
    if (i > paginations.length - 2) return false
    let aimPagination = paginations[i + 1]
    toggleQuestion(aimPagination, activeQuestion)
    toggleNav(aimPagination, activePagination)
  }

}



function toggleNav(aimPagination, activePagination) {
  activePagination.classList.toggle('active')
  aimPagination.classList.toggle('active')
}

function toggleQuestion(aimPaginationId, activeQuestion) {
  let aimQuestionId = aimPaginationId.dataset.pagination
  let aimQuestion = $(`.question[data-id='${aimQuestionId}']`)[0]
  aimQuestion.classList.toggle('show')
  activeQuestion.classList.toggle('show')
}


function handleClick({target}) {

  if (!target.dataset.pagination) return;

  if (target.classList.contains('active')) return

  let active_btn = $('.pagination .active')[0]
  active_btn.classList.remove('active')
  target.classList.add('active')

  let id_to_hide = active_btn.dataset['pagination']
  $(`.question[data-id="${id_to_hide}"]`).removeClass('show')

  let id_to_show = target.dataset['pagination']
  $(`.question[data-id="${id_to_show}"]`).addClass('show')
}

function navInit() {
  let nav_buttons = $('[data-pagination]')
  if (!nav_buttons[0]) return false
  Array.from(nav_buttons).map((nav) => {
    nav.classList.remove('active')
  })
  nav_buttons[0].classList.add('active')
}




