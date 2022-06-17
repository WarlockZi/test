import './do.scss'

import {_test} from "./model/test"
import {post, $} from '../common'
import {navInit} from '../components/test-pagination/test-pagination'


export default function testDo() {

//Скрыть все вопросы
  $('.question').removeClass("show")

//Показть первый вопрос
  $('.question:first-child').addClass("show")
// Нажать первуюкнопку navigation
  navInit()
  $('.test-do [type="checkbox"]').on('click', function (e) {
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
    if (button.id !== 'btnn') return false

    if (button.text === "ПРОЙТИ ТЕСТ ЗАНОВО") {
      location.reload();
      return;
    }
    button.text = "ПРОЙТИ ТЕСТ ЗАНОВО"

    button.classList.add('inactive')

    let corrAnswers = await post('/test/getCorrectAnswers', {})
    let errorCnt = colorView(corrAnswers)

    let data = objToServer(errorCnt)
    let res = await post('/adminsc/testresult/cachePageSendEmail', {...data})
    if (res==='ok') {
      $("#btnn")[0].href = location.href
      $("#btnn")[0].text = "ПРОЙТИ ТЕСТ ЗАНОВО"
    }
  })
  function replaceNbsps(str) {
    var re = new RegExp('&nbsp;?', "g");
    return str.replace(re, " ");
  }
  function replaceNs(str) {
    var re = new RegExp('\\n?', "g");
    return str.replace(re, "");
  }
  function replaceTs(str) {
    var re = new RegExp('\\t?', "g");
    return str.replace(re, "");
  }
  function cachePage(rightAnswers) {
    let t = $('.test-do')[0]
    t = t.outerHTML
    t = replaceNbsps(t)
    t = replaceNs(t)
    t = replaceTs(t)
    return t
  }

  function objToServer(errorCnt) {
    return {
      questionCnt: $('.question').length,
      errorCnt: errorCnt,
      html: cachePage(),
      testid: $('[data-test-id]')[0].dataset.testId,
      testname: $('.test-name')[0].innerText,
      user: $('.user-menu__fio')[0].innerText,
    }
  }


  function colorView(correctAnswers) {
    let q = $('.question');
    [].map.call(q, function (question) {
      let answers = question.querySelectorAll('.a')
      let errors = [];
      [].map.call(answers, function (answer) {
        let input = $(answer).find('input')
        let id = answer.dataset.id
        checkCorrectAnswers(errors, id, correctAnswers, input, answer)
      })

      let id = question.dataset['id'] // id question
      let paginItem = $(`.pagination [data-pagination='${+id}']`)[0]
      if (errors.length) {
        $(paginItem).addClass('redShadow')
      } else {
        $(paginItem).addClass('greenShadow')
      }
    })
    return $('.redShadow').length
  }

  function checkCorrectAnswers(errors, id, correctAnswers, input, answer) {
    let correctAnser = correctAnswers.indexOf(id) !== -1

    if (input.checked && correctAnser) {// checkbox нажат. а в correct answer нету. в correct_answers есть, его всегда подсвечиваем зеленым
      answer.classList.add('done'); //green check зеленый значек
    } else if (input.checked && !correctAnser) {// checkbox нажат,и есть в correct answer. в correct_answers нет, кнопка не нажата
      errors.push(true)
    } else if (!input.checked && correctAnser) {// кнопка не нажата, в correct_answers есть
      answer.classList.add('done'); //green check зеленый значек
      errors.push(true)
    } else if (!input.checked && !correctAnser) {// кнопка не нажата, в correct_answers нет
    }
  }

}

