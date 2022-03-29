import './edit.scss'
import {post, $, validate, popup} from '../common'

$("#save").on("click", async function (e) {
    e.preventDefault()

    function sex() {
      const s = $('[name="sex"]').el
      for (let f of s) {
        if (f.checked) {
          return f.value
        }
      }
      return 'm'
    }

    let data = {
      // email: check_email(),
      name: $('[name = "name"]')[0].value,
      surName: $('[name = "surName"]')[0].value,
      middleName: $('[name = "middleName"]')[0].value,
      birthDate: $('[name = "birthDate"]')[0].value,
      phone: $('[name = "phone"]')[0].value,
      sex: sex()
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

