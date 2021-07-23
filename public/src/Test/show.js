import './show.scss'
import {post, $} from '../common'

$(".save-test").on('click', async function () {
    let test_name = $('#test_name').el[0].innerText
    let enable = 1
    let sel = $('select').el[0]
    let isTest = +!$('#isPath').el[0].checked
    let sort = 0
    let parent = sel.options[sel.selectedIndex].value

    let res = await post('/test/create', {
        test_name, enable, isTest, sort, parent,
    })
    res = await JSON.parse(res)
    if (res) {
        window.location.href = `/adminsc/test/edit/${res.id}`+'?id='+res.id+'&name='+test_name
    }

})