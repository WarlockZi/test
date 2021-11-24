import {$, popup, post} from '../../common'

export let _answer = {

    el: (add_button) => {
        let answers = add_button.parentNode.querySelectorAll('.answer')
        let prev_sort = 0
        if (answers.length) {
            prev_sort = +$(answers[answers.length - 1]).find('.answer__sort').innerText
        }
        let el = $('.answer__create').find('.answer').cloneNode(true)
        el.classList.add('answer')
        el.classList.remove('answer__create')
        return {
            el: el,
            id: 'new',
            q_id: +add_button.closest('.question-edit').id,
            previous_sort: prev_sort,
            sort: $(el).find('.answer__sort'),
            checked: $(el).find('input'),
            text: $(el).find('.answer__text'),
            delete: $($(el).find('.answer__delete')).on('click', function () {
                _answer.del(this)
            })
        }
    },
    getModelForServer(el) {
        return {
            answer: '',
            parent_question: el.q_id,
            correct_answer: 0,
            pica: ''
        }
    },

    async create(e) {
        let button = e.target
        let a_id = await createOnServer(button)
        show(a_id)

        async function createOnServer(button) {
            let newEl = _answer.getModelForServer(_answer.el(button))

            let res = await post('/answer/create', newEl)
            res = JSON.parse(res)

            return res.id
        }

        function show(a_id) {
            let el = _answer.el(button)

            el.checked.checked = false
            el.el.dataset['answerId'] = a_id
            el.text.innerText = ''
            el.sort.innerText = el.previous_sort + 1

            el.el.style.display = 'flex'
            button.before(el.el)
            el.el.style.opacity = 1
        }
    },

    async del(e) {
        let del_button = e.target
        if (confirm("Удалить этот ответ?")) {
            await deleteFromServer(del_button)
            deleteFromView(del_button)
        }

        function deleteFromView(del_button) {
            del_button.closest('.answer').remove()
        }

        async function deleteFromServer(del_button) {

            let a_id = +del_button.closest('.answer').dataset['answerId']
            let res = await post('/answer/delete', {a_id})
            res = JSON.parse(res)
            if (res.msg === 'ok') {
                popup.show('Ответ удален')
            }
        }
    },
}
