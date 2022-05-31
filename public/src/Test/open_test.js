import './open_test.scss'
import {$, popup, post, debounce, IsJsonString} from "../common";

let openTest = $('.opentest_wrap')[0]
if (openTest) {
  $(openTest).on('click', handleClick)

  // let debouncedInput = debounce(handleKeyup)
  $(openTest).on('keyup', handleKeyup)
}

function handleKeyup({target}) {
  if (target.tagName.toLowerCase() === 'textarea') {
    if (!target.value) {
      let activePagination = $('[data-pagination].active')[0]
      activePagination.classList.remove('filled')
    } else {
      let activePagination = $('[data-pagination].active')[0]
      activePagination.classList.add('filled')
    }
  }

}

async function handleClick({target}) {
  let testid = target.dataset.id
  let activeQuestion = $('.question.show')[0]
  let paginations = $('[data-pagination]')
  let activePagination = $('[data-pagination].active')[0]
  let i = paginations.indexOf(activePagination)

  if (target.id === 'prev') {
    if (i < 1) return false
    let aimPagination = paginations[i - 1]
    toggleQuestion(aimPagination, activeQuestion)
    toggleNav(aimPagination, activePagination)
  } else if (target.id === 'next') {
    if (i > paginations.length - 2) return false
    let aimPagination = paginations[i + 1]
    toggleQuestion(aimPagination, activeQuestion)
    toggleNav(aimPagination, activePagination)
  } else if (target.dataset.pagination) {
    if (target === activePagination) return false
    let aimPagination = target
    toggleQuestion(aimPagination, activeQuestion)
    toggleNav(aimPagination, activePagination)
  } else if (target.id === 'finish') {

    let answers = await getAnswers(testid)

    let obj = {
      questionCnt: paginations.length,
      html: `<!DOCTYPE ${document.doctype.name}>` + document.documentElement.outerHTML,
      testname: $('.test-name')[0].innerText,
      username: $('.user-menu__fio')[0].innerText,
    }

    let res = await post('/adminsc/opentestresult/finish', obj)
    if (IsJsonString(res)) {
      res = JSON.parse(res)
      if (res.msg === 'ok') {
        popup.show(res.msg)
      }
    }
  }
}

async function getAnswers(id) {
  let res = await post('/adminsc/opentestresult/getanswers', {id})
  res = JSON.parse(res)
  return res.msg
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