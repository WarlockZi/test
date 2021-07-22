import './autocomplete.scss';
import {$} from '../../common'

let inp = $("#autocomplete").el

Array.from(inp).map((inp) => {
    if (inp) {
        inp.addEventListener('input', function () {
            autocomplete(this.value, inp)
        })
    }
})


async function fetchJson(Input) {
    let response = await fetch('/search?q=' + Input);
    return await response.json();
}

function decorate(content, tag) {
    let el = document.createElement(tag)
    el.appendChild(content)
    return el
}

async function autocomplete(val, inp) {
    if (val.length < 1) {
        result.innerHTML = '';
        return
    }

    let data = await fetchJson(val);
    let ul = document.createElement('ul')

    let lis = data.map(e => {
        let a = document.createElement("a")
        a.href = e.alias
        a.innerHTML =`<img src='/pic/${e.preview_pic}' alt='${e.name}'>` + e.name
        ul.appendChild(decorate(a, 'li'))
    });

    let result = $(inp.parentNode).find('.search__result')
    result.appendChild(ul)

    $('body').on('click', function (e) {
        const search = $('.result-search ul').el[0]
        if ($('.result-search ul') && e.target !== search) {
            search.remove();
        }
    });
}

