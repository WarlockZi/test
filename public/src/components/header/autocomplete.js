import './autocomplete.scss';
import {$} from '../../common'

[...$(".search input")].map((input) => {
    if (input) {
        input.addEventListener('input', function () {
            autocomplete(input)
        }, true)
    }
});


async function autocomplete(input) {
    let search = input.parentNode;
    let result = $(search).find('.search__result');

    if (input.value.length < 1) {
        if (result) result.innerHTML = '';
        return
    }

    let data = await fetch('/search?q=' + input.value);
    data = await data.json(data);

    if (result.childNodes.length!==0) {
        result.innerHTML = ''
    }

    data.map(e => {
        let a = document.createElement("a");
        a.href = e.alias;
        a.innerHTML = `<img src='/pic/${e.preview_pic}' alt='${e.name}'>` + e.name;
        result.appendChild(a)
    });

    $('body').on('click', function (e) {
        if (result && e.target !== result) {
            result.innerHTML = '';
        }
    });
}

