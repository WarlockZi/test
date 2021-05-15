import './autocomplete.sass';

window.onload = function() {
    let inp = document.querySelector('#autocomplete').
    addEventListener('input', function () {
        autocomplete(this.value)
    })
}

async function fetchJson(Input) {
    let response = await fetch('/search?q=' + Input);
    return await response.json();
}

async function autocomplete(val) {
    if (val.length<1) {
        result.innerHTML = '';
        return
    }

    var data = await fetchJson(val);
    debugger;

    var res = '<ul>';
    data.forEach(e => {
        res += '<li>' +
            `<a href = '${e.alias}'>` +
            `<img src='/pic/${e.preview_pic}' alt='${e.name}'>` +
            e.name +
            '</a></li>';
    });
    res += '</ul>';
    var result = document.querySelector('.result-search');
    result.innerHTML = res;

    document.querySelector('body').addEventListener('click', function (e) {
        const search = document.querySelector('.result-search ul');
        if (document.querySelector('.result-search ul') && e.target !== search) {
            search.remove();
        }
    });
}

export default autocomplete
