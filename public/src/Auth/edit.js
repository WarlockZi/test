import './edit.scss'
import {post, $, validate, popup} from '../common'

$("#save").on("click", async function (e) {
    e.preventDefault()

    const s = $('[name="sex"]').el
    let sex = ''
    for (const f of s) {
      if (f.checked) {
        sex = f.value
      }
    }
    debugger
    let data = {
      // email: check_email(),
      name: $('[name = "name"]').el[0].value,
      surName: $('[name = "surName"]').el[0].value,
      middleName: $('[name = "middleName"]').el[0].value,
      birthDate: $('[name = "birthDate"]').el[0].value,
      phone: $('[name = "phone"]').el[0].value,
      sex: sex,
    }

    let res = await post('/user/edit', data)
    if (res === 'ok') {
      popup.show('Сохранено')
    }

  }
)


// setTimeout(function () {
//     let p = document.querySelector("p.result");
//     p.parentNode.remove();
// }, 2000);

