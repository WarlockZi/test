import {$, post} from '../../common'

export default function user() {

  $('#user-update-btn').on('click', save)

  async function save(e) {
    let rights = $('input.right:checked')
    rights = rights.map((r) => r.previousElementSibling.innerHTML)
    rights = rights.join(',');
    let sel = $('.tabs').find('#conf')
    let conf = sel.options[sel.options.selectedIndex].value

    function sex() {
      const f = $('[name="sex"]:checked')[0]
      const s = $('[name="sex"]').el
      for (let f of s) {
        if (f.checked) {
          return f.value
        }
      }
      return 'm'
    }
    const model = {
      id: $('.tabs').find('#id').innerText.trim(),
      confirm: conf,
      name: $('.tabs').find('#name').innerText,
      surName: $('.tabs').find('#s-name').innerText,
      email: $('.tabs').find('#email').innerText.trim(),
      middleName: $('.tabs').find('#m-name').innerText,
      phone: $('.tabs').find('#phone').innerText,
      birthDate: $('.tabs').find('#bday').value,
      hired: $('.tabs').find('#hired').value,
      fired: $('.tabs').find('#fired').value,
      rights: rights,
      sex: sex(),
    }

    let res = await post('/user/update', model)


  }
}











