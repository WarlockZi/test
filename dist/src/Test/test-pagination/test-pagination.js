import './test-pagination.scss'
import {$} from "../../common";

export default class Pagination {

  constructor(props) {

    this.pClass = props.pClass ?? ''
    this.pActiveClass = props.pActiveClass ?? ''

    this.pageClass = props.pageClass ?? ''
    this.pageActiveClass = props.pageActiveClass ?? ''

    this.prevBttnId = props.prevBttnId ?? null
    this.nextBttnId = props.nextBttnId ?? null

    this.paginations = $(this.pClass)
    this.activePClass =  `${this.pClass}.${this.pActiveClass}`
    this.activePageClass =  `.${this.pageClass}.${this.pageActiveClass}`

    if (this.paginations.length) {
      this.navInit()
      $(this.pClass).on('click', this.handleClick.bind(this))

      if (this.prevBttnId) {
        $(this.prevBttnId).on('click', this.handleNextPrev.bind(this))
        $(this.nextBttnId).on('click', this.handleNextPrev.bind(this))
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
    // debugger
    let activePage = $(this.activePageClass)[0]
    let activeP = $(this.activePClass)[0]
    let i = this.paginations.indexOf(activeP)
    if (target === this.prevBttnId) {
      handlePrevClick.call(this)
    } else if (target === this.nextBttnId) {
      handleNextClick.call(this)
    }

    function handlePrevClick() {
      if (i < 1) return false
      let aimPagination = this.paginations[i - 1]
      this.togglePage(aimPagination, activePage).bind(this)
      this.toggleNav(aimPagination, activeP)
    }

    function handleNextClick() {
      if (i > this.paginations.length - 2) return false
      let aimPagination = this.paginations[i + 1]
      this.togglePage(aimPagination, activePage).bind(this)
      this.toggleNav(aimPagination, activeP)
    }
  }

  toggleNav(aimP, activeP) {
    activeP.classList.toggle(this.pActiveClass)
    aimP.classList.toggle(this.pActiveClass)
  }

  togglePage(aimPId, activePage) {
    let aimPageId = aimPId.dataset.pagination
    let aimPage = $(`.${this.pageClass}[data-id='${aimPageId}']`)[0]
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





