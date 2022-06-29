import './test-pagination.scss'
import {$} from "../../common";


export default class Pagination {


  constructor(props) {
    this.pClass = props.pClass ?? ''
    this.pActiveClass = props.pActiveClass ?? ''
    this.pageClass = props.pageClass ?? ''
    this.pageActiveClass = props.pageActiveClass ?? ''
    this.prevBttnEl = props.prevBttnEl ?? null
    this.nextBttnEl = props.nextBttnEl ?? null

    this.paginations = $(this.pClass)
    this.activePClass =  this.pClass +'.'+ this.pActiveClass
    this.activePageClass =  '.'+this.pageClass +'.'+ this.pageActiveClass

    if (this.paginations.length) {
      this.navInit()
      $(this.pClass).on('click', this.handleClick.bind(this))

      if (this.prevBttnEl) {
        $(this.prevBttnEl).on('click', this.handleNextPrev.bind(this))
        $(this.nextBttnEl).on('click', this.handleNextPrev.bind(this))
      }
    }
  }

  navInit() {
    [].map.call(this.paginations, (nav) => {
      nav.classList.remove(this.pActiveClass)
    })
    this.paginations[0].classList.add(this.pActiveClass)
  }

  handleNextPrev({target}) {
    let activePage = $(this.activePageClass)[0]
    let activeP = $(this.activePClass)[0]
    let i = this.paginations.indexOf(activeP)
    if (target === this.prevBttnEl) {
      handlePrevClick.call(this)
    } else if (target === this.nextBttnEl) {
      handleNextClick.call(this)
    }

    function handlePrevClick() {
      if (i < 1) return false
      let aimPagination = this.paginations[i - 1]
      this.togglePage(aimPagination, activePage)
      this.toggleNav(aimPagination, activeP)
    }

    function handleNextClick() {
      if (i > this.paginations.length - 2) return false
      let aimPagination = this.paginations[i + 1]
      this.togglePage(aimPagination, activePage)
      this.toggleNav(aimPagination, activeP)
    }
  }

  toggleNav(aimP, activeP) {
    activeP.classList.toggle(this.pActiveClass)
    aimP.classList.toggle(this.pActiveClass)
  }

  togglePage(aimPId, activePage) {
    let aimPageId = aimPId.dataset.pagination
    let aimPage = $(`.question[data-id='${aimPageId}']`)[0]
    aimPage.classList.toggle(this.pageActiveClass)
    activePage.classList.toggle(this.pageActiveClass)
  }

  handleClick({target}) {
    if (!target.dataset.pagination) return;
    if (target.classList.contains(this.pActiveClass)) return
    let active_btn = $(this.activePClass)[0]
    active_btn.classList.remove(this.pActiveClass)
    target.classList.add(this.pActiveClass)

    let id_to_hide = active_btn.dataset['pagination']
    $(`.${this.pageClass}[data-id="${id_to_hide}"]`).removeClass(this.pageActiveClass)

    let id_to_show = target.dataset['pagination']
    $(`.${this.pageClass}[data-id="${id_to_show}"]`).addClass(this.pageActiveClass)
  }

}
//
// let paginations = $(`[data-pagination]`)
// if (paginations.length) {
//   navInit()
//   $(`[data-pagination]`).on('click', handleClick)
//
//   let prev = $('#prev')[0]
//   let next = $('#next')[0]
//
//   if (next) {
//     $(next).on('click', handleNextPrev)
//     $(prev).on('click', handleNextPrev)
//   }
// }
//
// function navInit() {
//   [].map.call(paginations, (nav) => {
//     nav.classList.remove('active')
//   })
//   paginations[0].classList.add('active')
// }
//
//
// function handleNextPrev({target}) {
//   let activeQuestion = $('.question.show')[0]
//   let activePagination = $(`[data-pagination].active`)[0]
//   let i = paginations.indexOf(activePagination)
//   if (target.id === 'prev') {
//     handlePrevClick()
//   } else if (target.id === 'next') {
//     handleNextClick()
//   }
//
//   function handlePrevClick() {
//     if (i < 1) return false
//     let aimPagination = paginations[i - 1]
//     toggleQuestion(aimPagination, activeQuestion)
//     toggleNav(aimPagination, activePagination)
//   }
//
//   function handleNextClick() {
//     if (i > paginations.length - 2) return false
//     let aimPagination = paginations[i + 1]
//     toggleQuestion(aimPagination, activeQuestion)
//     toggleNav(aimPagination, activePagination)
//   }
// }
//
//
// function toggleNav(aimPagination, activePagination) {
//   activePagination.classList.toggle('active')
//   aimPagination.classList.toggle('active')
// }
//
// function toggleQuestion(aimPaginationId, activeQuestion) {
//   let aimQuestionId = aimPaginationId.dataset.pagination
//   let aimQuestion = $(`.question[data-id='${aimQuestionId}']`)[0]
//   aimQuestion.classList.toggle('show')
//   activeQuestion.classList.toggle('show')
// }
//
//
// function handleClick({target}) {
//
//   if (!target.dataset.pagination) return;
//   if (target.classList.contains('active')) return
//
//   let active_btn = $('.pagination .active')[0]
//   active_btn.classList.remove('active')
//   target.classList.add('active')
//
//   let id_to_hide = active_btn.dataset['pagination']
//   $(`.question[data-id="${id_to_hide}"]`).removeClass('show')
//
//   let id_to_show = target.dataset['pagination']
//   $(`.question[data-id="${id_to_show}"]`).addClass('show')
// }






