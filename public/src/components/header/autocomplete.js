import './autocomplete.scss';
import {$} from '../../common'

let inp = $("#autocomplete").el

Array.from(inp).map((inp)=>{
    if (inp){
        inp.addEventListener('input', function () {
            autocomplete(this.value, inp)
        })
    }
})



async function fetchJson(Input) {
    let response = await fetch('/search?q=' + Input);
    return await response.json();
}


async function autocomplete(val, inp) {
    if (val.length < 1) {
        result.innerHTML = '';
        return
    }

    let data = await fetchJson(val);

    let res = '<ul>';
    data.forEach(e => {
        res += '<li>' +
            `<a href = '${e.alias}'>` +
            `<img src='/pic/${e.preview_pic}' alt='${e.name}'>` +
            e.name +
            '</a></li>'
    });
    res += '</ul>'
    let result = $(inp.parentNode).find('.result-search')
    result.innerHTML = res

    $('body').on('click', function (e) {
        const search = $('.result-search ul').el[0]
        if ($('.result-search ul') && e.target !== search) {
            search.remove();
        }
    });
}

