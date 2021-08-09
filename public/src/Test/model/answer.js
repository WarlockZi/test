import {$, popup, post} from '../../common'

export let _answer = {

    create: async (e) => {
        if ($(e.target).hasClass('a-add')) {
            let q_id = +e.target.closest('.e-block-q').id
            let res = await post('/answer/show', {q_id})
            let visibleBlock = $('.block.flex1').el[0]
            $(visibleBlock).find('.answers').insertAdjacentHTML('beforeend', res)
            let newAnswer = $(visibleBlock).find('.e-block-a:last-child')
            $(newAnswer).css('background-color', 'pink')
            setTimeout(function () {
                    $(newAnswer).css('background-color', 'white')
                }, 400
            )
            $(newAnswer).on('click', this.delete)
        }
    },

    update: () => {

    },

    delete: async function (e) {
        if ($(e.target).hasClass('a-del')) {
            if (confirm("Удалить этот ответ?")) {
                let a_id = +e.target.closest('.e-block-a').id
                let res = await post('/answer/delete', {a_id})
                res = JSON.parse(res)
                if (res.msg === 'ok') {
                    let f = e.target.closest('.e-block-a')
                    f.remove()
                    popup.show('Ответ удален')
                }
            }
        }
    },

}