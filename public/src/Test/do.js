import './do.scss'



import {_test} from "./model/test"
import {post, $} from '../common'
import {navInit} from '../components/test-pagination/test-pagination'
import accordionShow from "./accordion-show";

export default function testDo() {

  accordionShow()

//Скрыть все вопросы
  $('.question').removeClass("flex1")

//Показть первый вопрос
  $('.question:first-child').addClass("flex1")
// Нажать первуюкнопку navigation
  navInit()
  $('.test-do__content [type="checkbox"]').on('click', function (e) {
    let a = e.target.labels[0]
    a.classList.toggle('pushed')
  })


  $('#prev').on('click', _test.prevQ)
  $('#next').on('click', _test.nextQ)


/////////////////////////////////////////////////////////////////////////////
///////////  RESULTS  TEST  Закончить тест/////////////////////////////
/////////////////////////////////////////////////////////////////////////////

// если это результат теста, деактивирукм кнопку Закончить тест
  let button = $('.test-do__finish-btn')[0]
  if (button) {
    if (window.location.pathname.match('^/test/result/.?')) {
      button.classList.add('inactive')
    }
  }

  $('.test-do__finish-btn').on('click', async function (e) {

    let button = e.target;
    if (button.classList.contains('inactive')) return false
    if (button.id !== 'btnn') return false

    if (button.text == "ПРОЙТИ ТЕСТ ЗАНОВО") {
      location.reload();
      return;
    }
    let corrAnswers = await post('/test/getCorrectAnswers', {})
    corrAnswers = JSON.parse(corrAnswers)
    let errorCnt = colorView(corrAnswers)
    let data = objToServer(errorCnt)
    let res = await post('/test/cachePageSendEmail', data)
    if (res) {
      $("#btnn")[0].href = location.href
      $("#btnn")[0].text = "ПРОЙТИ ТЕСТ ЗАНОВО"
    }
  })

  function objToServer(errorCnt) {

    let obj = {
      token: document.querySelector('meta[name="token"]').getAttribute('content'),
      questionCnt: $('.question').length,
      errorCnt: errorCnt,
      pageCache: `<!DOCTYPE ${document.doctype.name}>` + document.documentElement.outerHTML,
      testId: $('[data-test-id]')[0].dataset.testId,
      test_name: $('.test-name')[0].innerText,
      userName: $('.user-menu__fio')[0].innerText,
    }

    let formData = new FormData();
    formData.append('token', obj.token);
    formData.append('questionCnt', obj.questionCnt);
    formData.append('errorCnt', obj.errorCnt);
    formData.append('pageCache', obj.pageCache);
    formData.append('testId', obj.testId);
    formData.append('test_name', obj.test_name);
    formData.append('userName', obj.userName);
    return formData

    return obj
  }


  function colorView(correctAnswers) {
    let q = $('.question')
    Array.from(q).map((question, i) => {
      let answers = question.querySelectorAll('.a'),
        errors = []
      Array.from(answers).map((answer) => {
        let input = answer.getElementsByTagName('input')[0],
          answerId = input.id.replace("answer-", ""), // id question
          label = answer.getElementsByTagName('label')[0], // Чтобы прикрепить зеленый значек к этому элементу
          correctAnser = correctAnswers.indexOf(answerId) !== -1
        if (!checkCorrectAnswers(correctAnser, input, label)) {
          errors.push(true)
        }
      })

      let questId = +question.dataset['id'], // id question
        paginItem = $('.pagination [data-pagination="' + questId + '"]')[0]
      if (errors.length) {
        $(paginItem).addClass('redShadow')
      } else {
        $(paginItem).addClass('greenShadow')
      }
    })
    return $('.redShadow').length
  }

  function checkCorrectAnswers(correctAnser, input, label) {
    if (input.checked && correctAnser) {// checkbox нажат. а в correct answer нету. в correct_answers есть, его всегда подсвечиваем зеленым
      label.classList.add('done'); //green check зеленый значек
      return true
    } else if (input.checked && !correctAnser) {// checkbox нажат,и есть в correct answer. в correct_answers нет, кнопка не нажата
      return false
    } else if (!input.checked && correctAnser) {// кнопка не нажата, в correct_answers есть
      label.classList.add('done'); //green check зеленый значек
      label.classList.add('done');// green check зеленый значек
      return false
    } else if (!input.checked && !correctAnser) {// кнопка не нажата, в correct_answers нет
      return true
    }
  }

}

