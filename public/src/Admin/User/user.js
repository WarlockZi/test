import './users.scss'

import {$, popup, post} from '../../common'
import getSex from '../../Auth/getSex'

export default function user() {

  let item = $('.user-item')[0]
  if (item) {
    $(item).on('click', handleClick)
  }

  async function handleClick({target}) {
    if (!!target.closest('#save')) {

      let wrapper = $('.user-item')[0]
      let data = getModel(wrapper)

      let res = await post('/adminsc/user/update', data)
      if (res === 'ok') {
        popup.show('Сохранено')
      }
    }
  }

  function rights(){
    let right = $('.right:checked')
    let rights = '';
    [].map.call(right,(r)=>{
      let str = r.previousElementSibling.innerText+','
      rights+=str
    },rights)
    return rights
  }

  function confirm() {
    const confirm = $('#conf option')
    for (let f of confirm) {
      if (f.selected) {
        return f.value
      }
    }
    return '0'
  }


  function getModel(target) {
    return {
      id: $(target).find("#id").innerText,
      name: $(target).find('#name').innerText,
      surName: $(target).find('#s-name').innerText,
      middleName: $(target).find('#m-name').innerText,
      birthDate: $(target).find('#bday').innerText,
      phone: $(target).find('#phone').innerText,
      email: $(target).find('#email').innerText,
      hired: $(target).find('#hired').innerText,
      fired: $(target).find('#fired').innerText,
      confirm: confirm(),
      sex: getSex(),
      rights:rights()
    }
  }
}











