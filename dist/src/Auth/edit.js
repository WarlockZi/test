import './edit.scss'
import {post, $, popup} from '../common'
import getSex from './getSex'

$("#save").on("click", async function (e) {
    e.preventDefault()

    let data = {
      name: $('[name = "name"]')[0].value,
      surName: $('[name = "surName"]')[0].value,
      middleName: $('[name = "middleName"]')[0].value,
      birthDate: $('[name = "birthDate"]')[0].value,
      phone: $('[name = "phone"]')[0].value,
      sex: getSex()
    }

    let res = await post('/user/edit', data)

  }
)


