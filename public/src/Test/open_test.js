import './open_test.scss'
import {$, popup, post, debounce, IsJsonString} from "../common";

let openTest = $('.opentest_wrap')[0]
if (openTest) {
  $(openTest).on('click', handleClick)
  $(openTest).on('keyup', handleKeyup)
}

function handleKeyup({target}) {
  if (target.classList.contains('textarea')) {
    let activePagination = $('[data-pagination].active')[0]
    if (!target.innerText) {
      activePagination.classList.remove('filled')
    } else {
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
    prevQuest()
  } else if (target.id === 'next') {
    nextQuest()
  } else if (target.dataset.pagination) {
    paginate()
  } else if (target.id === 'finish') {
    finish()
  }

  async function finish() {
    let questions = await getAnswers(testid)
    parseAnswers(questions)
    let conuntRightAnswers = countRightAnswers()
    let obj = cachePage(conuntRightAnswers)
    if (1) return
    let res = await post('/adminsc/opentestresult/finish', obj)
    if (IsJsonString(res)) {
      res = JSON.parse(res)
      if (res.msg === 'ok') {
        popup.show(res.msg)
      }
    }
  }

  function cachePage(rightAnswers) {
    return {
      testId: +testid,
      questionCnt: paginations.length,
      rightAnswers,
      html: `<!DOCTYPE ${document.doctype.name}>` + document.documentElement.outerHTML,
      testname: $('.test-name')[0].innerText,
      username: $('.user-menu__fio')[0].innerText,
    }
  }

  function countRightAnswers() {
    // let questions = $('.question')
    // questions.forEach((q)=>{
    //
    // })
    let answers = $('.textarea')
    return answers.reduce((acc, curent, i, array) => {
      if ($(curent).find('span')) return ++acc
      return acc
    }, 0)
  }

  function paginate() {
    if (target === activePagination) return false
    let aimPagination = target
    toggleQuestion(aimPagination, activeQuestion)
    toggleNav(aimPagination, activePagination)
  }

  function prevQuest() {
    if (i < 1) return false
    let aimPagination = paginations[i - 1]
    toggleQuestion(aimPagination, activeQuestion)
    toggleNav(aimPagination, activePagination)
  }

  function nextQuest() {
    if (i > paginations.length - 2) return false
    let aimPagination = paginations[i + 1]
    toggleQuestion(aimPagination, activeQuestion)
    toggleNav(aimPagination, activePagination)
  }
}


function parseAnswers(questions) {
  questions.forEach((q) => {
    let q_id = q.id
    let q_el = $(`.question[data-id='${q_id}']`)[0]
    let textarea = $(q_el).find('.textarea')
    if (!q.Openanswer) return
    let word = ''
    q.Openanswer.forEach((a) => {
      word += `(${a.answer}).?`
    })
    highlight(`${word}`, textarea, true)
  })
}

function hiliter(word, element, addEventLis) {
  let text = element.innerHTML
  let rgxp = new RegExp(word, 'g');
  let arr = rgxp.exec(text)
  delete arr[0]
  arr.forEach((w) => {
    let r = new RegExp(w, 'g')
    let repl = `<span style='color:red;'>` + w + '</span>';
    element.innerHTML = element.innerHTML.replace(r, repl);
  })

  addEventLis && element.addEventListener("input", function remove() {
    removeHighlight();
    highlight(false);
    element.removeEventListener("input", remove);
  });
}

async function getAnswers(id) {
  let res = await post('/adminsc/opentestresult/getanswers', {id})
  res = JSON.parse(res)
  return res
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

function highlight(word, el, addEventLis) {
  hiliter(word, el, addEventLis);
  placeCaretAtEnd(el);
}

function placeCaretAtEnd(el) {
  el.focus();
  if (typeof window.getSelection != "undefined" &&
    typeof document.createRange != "undefined") {
    var range = document.createRange();
    range.selectNodeContents(el);
    range.collapse(false);
    var sel = window.getSelection();
    sel.removeAllRanges();
    sel.addRange(range);
  } else if (typeof document.body.createTextRange != "undefined") {
    var textRange = document.body.createTextRange();
    textRange.moveToElementText(el);
    textRange.collapse(false);
    textRange.select();
  }
}


function removeHighlight(e) {
  let element = document.getElementById("textBox");
  let i = element.innerHTML.replaceAll('<span style="color:#6ca3fe;font-weight: 600">', "");
  i = i.replaceAll('</span>', "");
  element.innerHTML = i;
  placeCaretAtEnd(document.getElementById("textBox"))
}
