import './test-pagination.scss'

window.onload = function () {

//Показать первый вопрос
    document.querySelector('.test-data .question:first-child').style.display = "flex"
// Показать первую кнопку
    document.querySelector('[data-pagination]:first-child').classList.add('nav-active')

// Пагинация
    document.querySelector('.pagination').addEventListener('click', function (e) {
        let target = e.target
        if (target.classList.contains('pagination')) return
        let clicked_btn = target.closest('[data-pagination]')
        if (clicked_btn.classList.contains('nav-active')) return

        let active_btn = document.querySelector('.pagination .nav-active')
        active_btn.classList.remove('nav-active')
        clicked_btn.classList.add('nav-active')

        // hide the card
        let id_to_hide = active_btn.dataset['pagination']
        let link_to_hide = `.question[data-id="${id_to_hide}"]`
        document.querySelector(link_to_hide).style.display = 'none'
        // show the card
        let id_to_show = clicked_btn.dataset['pagination']
        let link_to_show = `.question[data-id="${id_to_show}"]`
        document.querySelector(link_to_show).style.display = 'flex'
    })
}